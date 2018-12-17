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
        $stop_comment=DB::table('settings')->where('name','stop_comment')->value('value');
        $posts=Post::all();
        $users=User::all();
        $n=count($posts);
        $j=$n;
        $de=[];
        for($i=0;$i<$n;$i++)
        {
            $de[$i]=$posts[$j-1];
            $j--;
        }
        $posts=$de;
        return view('content.posts',compact('posts','stop_comment','users'));
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
        $stop_comment=DB::table('settings')->where('name','stop_comment')->value('value');
        $stop_register=DB::table('settings')->where('name','stop_register')->value('value');
      return view('content.admin',compact('users','stop_comment','stop_register'));
    }

    public function settings(Request $request)
    {
           if($request->stop_comment)
           {
               Db::table('settings')->where('name','stop_comment')->update(['value'=>1]);
           }
           else{
            Db::table('settings')->where('name','stop_comment')->update(['value'=>0]);
           }

           if($request->stop_register)
           {
               Db::table('settings')->where('name','stop_register')->update(['value'=>1]);
           }
           else{
            Db::table('settings')->where('name','stop_register')->update(['value'=>0]);
           }

           return redirect()->back();
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

    public function statics()
    {
        $users=DB::table('users')->count();
        $posts=DB::table('posts')->count();
        $comments=DB::table('comments')->count();
        
        //user_1 most comments
        $most_commets_user= User::withCount('comments')
        ->orderBy('comments_count','desc')
        ->first();

        $likes_count_1=DB::table('likes')->where('user_id',$most_commets_user->id)->count();
        $user_1_count=$most_commets_user->comments_count+$likes_count_1;

        //user_2 most likes
        $most_likes_user= User::withCount('likes')
        ->orderBy('likes_count','desc')
        ->first();
        $comments_count_2=DB::table('comments')->where('user_id',$most_likes_user->id)->count();
        $user_2_count=$most_likes_user->likes_count+$comments_count_2;

        if($user_1_count>$user_2_count)
        {
            $acive_user=$most_commets_user->name;
            $acive_user_likes=$likes_count_1;
            $acive_user_comments=$most_commets_user->comments_count;
        }
        else
        {
            $acive_user=$most_likes_user->name;
            $acive_user_likes=$most_likes_user->likes_count;
            $acive_user_comments=$comments_count_2;
        }
 
        /////////////////////////////////////////////////////////////////////////////////////
        //user_1 most comments
        $most_commets_user_p= Post::withCount('comments')
        ->orderBy('comments_count','desc')
        ->first();

        $likes_count_1_p=DB::table('likes')->where('post_id',$most_commets_user_p->id)->count();
        $user_1_count_p=$most_commets_user_p->comments_count+$likes_count_1_p;

        //user_2 most likes
        $most_likes_user_p= Post::withCount('likes')
        ->orderBy('likes_count','desc')
        ->first();
        $comments_count_2_p=DB::table('comments')->where('user_id',$most_likes_user_p->id)->count();
        $user_2_count_p=$most_likes_user_p->likes_count+$comments_count_2_p;

        if($user_1_count_p>$user_2_count_p)
        {
            $acive_post_title=$most_commets_user_p->title;
            $acive_post_body=$most_commets_user_p->body;
            $acive_post_url=$most_commets_user_p->url;
            $acive_post_likes=$likes_count_1_p;
            $acive_post_comments=$most_commets_user_p->comments_count;
        }
        else
        {
            $acive_post_title=$most_likes_user_p->title;
            $acive_post_body=$most_likes_user_p->body;
            $acive_post_url=$most_likes_user_p->url;
            $acive_post_likes=$most_likes_user_p->likes_count;
            $acive_post_comments=$comments_count_2;
        }

     
        $statics=array(
            'users'=>$users,
            'posts'=>$posts,
            'comments'=>$comments,
            'acive_user'=>$acive_user,
            'acive_user_likes'=>$acive_user_likes,
            'acive_user_comments'=>$acive_user_comments,
            'acive_post_title'=>$acive_post_title,
            'acive_post_body'=>$acive_post_body,
            'acive_post_url'=>$acive_post_url,
            'acive_post_likes'=>$acive_post_likes,
            'acive_post_comments'=>$acive_post_comments,
        );

        return view('content.statics',compact('statics'));
    }

}
