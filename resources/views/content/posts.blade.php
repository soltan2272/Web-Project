@extends('master')

@section('content')

<meta id="token" name="token" content="{{csrf_token()}}">
<div  class="container d-flex h-100">
<div class="row justify-content-center align-self-center">
        @foreach($posts as $post)
        <div class="well">
                <div class="media">
                 <a class="pull-left" href="#">
        </a>
        
    <h1 style=" color:brown;"  class="glyphicon glyphicon-user"> <a style=" color:black;">
            <strong>  {{ $post->category->name }} </strong> 
           <b> </a> {{ $post->pub_name }}  </h1><b>
<h2>
<b><a style=" color:blue;font-size:30px;" href="/posts/{{$post->id}}">{{$post->title}}</a></b>
</h2>
<p> 
   
        <p><span style="font-size:30px;" class="glyphicon glyphicon-time"></span> Posted on {{$post->created_at->toDateTimeString()}}
            <div class="media-body">
                    
                    <p style="font-size:20px;"><b> {{ $post->body }}</b></p>
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
                    <ul class="list-inline list-unstyled">
                        <li><span><i class="glyphicon glyphicon-calendar"></i> {{$post->created_at->diffForHumans()}} </span></li>
                      <li>|</li>
                      @php
                     $noc=0;
                     foreach($post->comments as $comment)
                      $noc++;
                     @endphp
                    <span><i class="glyphicon glyphicon-comment"></i> {{$noc}}comments</span>
                      <li>
                      
                        <span><i class="fa fa-facebook-square"></i></span>
                        <span><i class="fa fa-twitter-square"></i></span>
                        <span><i class="fa fa-google-plus-square"></i></span>
                      </li>
                      </ul>
                 </div>
        </p>
       
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
        <p>
            <?php
            $user_n='';
            ?>
      @foreach($users as $user)
       @if($user->id==$comment->user_id)
       @php
           $user_n=$user->name;
       @endphp
       @endif
      @endforeach
      
       <p> {{$user_n}} </p>
         </p>
        <p span class="glyphicon glyphicon-time"> {{ $comment->created_at->diffForHumans() }} </p>
         <h4><p><b> {{ $comment->body }} </b></p></h4>
        </div>
        <br>
        @endforeach
    
    </div>

    @if($stop_comment==1)
    <h3 color:red;> Oops!!! Comments Closed !!!</h3>
    @else
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
  @endif
 <?php 
 $on=0;
  $usr_id=Auth::user()->id;
  $pst_id=$post->id;

 ?>
 @foreach ($post->comments as $comment)
    @if($usr_id==$comment->user_id && $pst_id==$comment->post_id)
    @php
    $on=1;
    @endphp
    @endif
 @endforeach
  @if(Auth::user()->hasRole('professor'))
<a class="btn btn-danger" href="/posts/{{$post->id}}}"> Delete Post </a>
<a class="btn btn-success" href="/posts/edit/{{$post->id}}"> Edit Post </a> <br>
@endif

                    
              </div>
            </div>
    @endforeach
        


 
@stop