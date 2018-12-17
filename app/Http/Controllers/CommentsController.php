<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\Post;
class CommentsController extends Controller
{
    public function store(Post $post)
    {
      /*  $comment=new Comment;
        $comment->body=$request->body;
        $comment->post_id=$post->id;
        $comment->save();*/

        Comment::create([
            'body'=>request('body'),
            'post_id'=>$post->id,
        ]);
        return back();
    }
}
