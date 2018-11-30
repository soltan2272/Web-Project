@extends('master')

@section('content')

<meta id="token" name="token" content="{{csrf_token()}}">
<div  class="container d-flex h-100">
<div class="row justify-content-center align-self-center">
@foreach($posts as $post)
<h2 style=" color:brown;font-size:60px;"  class="glyphicon glyphicon-user"> {{ $post->pub_name }}  </h2>
<h3>
   
<a style=" color:blue;font-size:40px;" href="/posts/{{$post->id}}">{{$post->title}}</a>
</h3>


<p> 
   
        <p><span style="font-size:30px;" class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->diffForHumans()}}
       
            <a style=" color:black;font-size:30px;">
            <strong>  {{ $post->category->name }} </strong> 
            </a>
        </p>
        <p style="font-size:20px;"> {{ $post->body }}</p>
        @if($post->url)
        <?php
        $t=explode('.',$post->url);
        ?>
        @if($t[1]=='jpg'||$t[1]=='png'||$t[1]=='gif'||$t[1]=='tif')
        <embed src="upload/{{$post->url}}" height="400" width="400"/><br>
            <a class="btn btn-primary" href="upload/{{$post->url}}" > Download Image </a>
        @else 
            <a class="btn btn-primary" href="upload/{{$post->url}}" > Download File </a>
        @endif</p>
        @endif
<hr>
@php
$like_count=0;
$dislike_count=0;
$like_status="btn-secondary";
$dislike_status="btn-secondary";
@endphp
@foreach($post->likes as $like)
@php
if($like->like==1)
{
$like_count++;
}
if($like->like==0)
{
$dislike_count++;
}
if(Auth::check())
{
if($like->like==1 && $like->user_id==Auth::user()->id)
{
    $like_status="btn-success";
}
if($like->like==0 && $like->user_id==Auth::user()->id)
{
    $dislike_status="btn-danger";
}
}

@endphp
@endforeach
<button  type="button" data-postid="{{$post->id}}_l" data-like="{{$like_status}}" 
class="like btn {{$like_status}}" >Like 
<span class="glyphicon glyphicon-thumbs-up"></span><b><span class="like_count">{{$like_count}}</span></b></button>

<button  type="button" data-postid="{{$post->id}}_d" data-like="{{$dislike_status}}" 
class="dislike btn {{$dislike_status}}" >Dislike 
<span class="glyphicon glyphicon-thumbs-down"></span><b><span class="dislike_count">{{$dislike_count}}</span></b></button>
<br><br>
<div class="comments">

        @foreach($post->comments as $comment)
        <div class="comment">
        <p span class="glyphicon glyphicon-time"> {{ $comment->created_at->diffForHumans() }} </p>
         <p> {{ $comment->body }} </p>
        </div>
        <br>
        @endforeach
    
    </div>

<form method="post" action="/posts/{{$post->id}}/store" >
    {{csrf_field()}}
    <div class="form-group">
      <label for="body">Write Some thing .....</label>
      <textarea name="body" id="body" class="form-control"></textarea>
    </div>
    <div class="form-check">
        <button type="submit" class="btn btn-warning btn-lg active"> Add Comment </button>
    </div>
  </form> 
  <br>
  @if(Auth::user()->hasRole('professor'))
<a class="btn btn-danger" href="/posts/{{$post->id}}}"> Delete Post </a>
<a class="btn btn-success" href="/posts/edit/{{$post->id}}"> Edit Post </a> <br>
@endif
<hr><hr>
@endforeach



</div>
</div>

 
@stop