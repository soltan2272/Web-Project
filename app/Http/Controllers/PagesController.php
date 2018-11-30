<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Post;
use DB;
use App\Category;
use App\User;
use App\Role;
use App\Like;

class PagesController extends Controller
{
    public function posts()
    {
      
        $posts=Post::all();
        $n=count($posts);
        $j=$n;
        $de=[];
        for($i=0;$i<$n;$i++)
        {
            $de[$i]=$posts[$j-1];
            $j--;
        }
        $posts=$de;
        return view('content.posts',compact('posts'));
    }
    public function prof()
    {
        $posts=Post::all();
        return view('content.prof');
    }
    public function fileup()
    {
       
        return view('content.fileup');
    }
    public function std_aff()
    {
        $posts=Post::all();
        return view('content.std_aff');
    }

    public function post(Post $post)
    {
        //$post=DB::table('posts')->find($id);
       // $posts=Post::all();
       // $post=Post::find($id);
        return view('content.post',compact('post'));
    }

    public function store(Request $request)
    {
        $post=new Post;
        /*$post->title= $request->title;
        $post->body= $request->body;*/
        $this->validate(request(),[
            'title'=>'required|min:5',
            'body'=>'required'
            
        ]);
        if( $request->url==null)
        {
        $post->title= request('title');
        $post->body= request('body');
        $post->url= request('url');
        if(Auth::user()->hasRole('professor'))
        {
            $post->category_id=1;
        }
        if(Auth::user()->hasRole('student_aff'))
        {
            $post->category_id=2;
        }
        $post->pub_name=request('nameofpub');
        $post->save();
        }
        else
        {

            $post->title=request('title');
            $img_name=time().'.'.$request->url->getClientOriginalExtension();
            $post->body= request('body');
            $post->url=$img_name;
            if(Auth::user()->hasRole('professor'))
            {
            $post->category_id=1;
            }
            if(Auth::user()->hasRole('student_aff'))
            {
            $post->category_id=2;
            }
            $post->pub_name=request('nameofpub');
            $post->save();
            $request->url->move(public_path('upload'),$img_name);
        }

        //Post::create(request()->all());
       return redirect('/posts');
      // return  view('content.prof',compact('tyb'));

    }

    public function category($name)
    {
        $cat=DB::table('categories')->where('name' , $name)->value('id');
        $posts=DB::table('posts')->where('category_id' , $cat)->get();
        return view('content.category',compact('posts'));
    }

    public function admin()
    {
        $users=User::all();
      return view('content.admin',compact('users'));
    }

    public function addrole(Request $request)
    {
       $user=User::where('email',$request['email'])->first();
       $user->roles()->detach();
       if($request['role_std'])
       {
           $user->roles()->attach(Role::where('name','student')->first());
       }
       if($request['role_std_aff'])
       {
           $user->roles()->attach(Role::where('name','student_aff')->first());
       }
       if($request['role_prof'])
       {
           $user->roles()->attach(Role::where('name','professor')->first());
       }
       return redirect()->back();
    }
    public function like(Request $request)
    {
      $like_s=$request->like_s;
      $post_id=$request->post_id;
      $is_like=0;
      $change_like=0;

      $like=DB::table('likes')
      ->where('post_id',$post_id)
      ->where('user_id',Auth::user()->id)
      ->first();
      if(!$like)
      {
          $new_like=new Like;
          $new_like->post_id=$post_id;
          $new_like->user_id=Auth::user()->id;
          $new_like->like=1;
          $new_like->save();

          $is_like=1;
      }
      else if($like->like==1)
      {
        DB::table('likes')
        ->where('post_id',$post_id)
        ->where('user_id',Auth::user()->id)
        ->delete();

        $is_like=0;
      }
      else if($like->like==0)
      {
        DB::table('likes')
        ->where('post_id',$post_id)
        ->where('user_id',Auth::user()->id)
        ->update(['like' => 1]);

        $is_like=1;
        $change_like=1;
      }
      $response=array(
       'is_like'=> $is_like,
       'change_like'=> $change_like,
      );
      return response()->json($response,200);
    }


    public function dislike(Request $request)
    {
      $like_s=$request->like_s;
      $post_id=$request->post_id;
      $change_dislike=0;
      $is_dislike=0;
     

      $dislike=DB::table('likes')
      ->where('post_id',$post_id)
      ->where('user_id',Auth::user()->id)
      ->first();

      if(!$dislike)
      {
          $new_like=new Like;
          $new_like->post_id=$post_id;
          $new_like->user_id=Auth::user()->id;
          $new_like->like=0;
          $new_like->save();

          $is_dislike=1;
      }
      elseif($dislike->like==0)
      {
        DB::table('likes')
        ->where('post_id',$post_id)
        ->where('user_id',Auth::user()->id)
        ->delete();

        $is_dislike=0;
      }
      elseif($dislike->like==1)
      {
        DB::table('likes')
        ->where('post_id',$post_id)
        ->where('user_id',Auth::user()->id)
        ->update(['like' => 1]);

        $is_dislike=1;
        $change_dislike=1;
      }
      $response=array(
       'is_dislike'=> $is_dislike,
       'change_dislike'=>  $change_dislike,
      );
      return response()->json($response,200);
    }

    public function delete(Post $post)
    {
       $post->delete();
       return redirect('/posts');
    }

    public function edit(Post $post)
    {
      return view('content.edit',compact('post'));
    }
    public function update(Post $post,Request $request)
    {
      $post->title= $request->title;
      $post->body= $request->body;
      $post->save();
      return redirect('/posts');
    }

}
