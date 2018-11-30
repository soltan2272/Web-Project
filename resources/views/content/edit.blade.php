@extends('master')

@section('content')


<h2 style=" color:green;font-size:60px;"  class="	glyphicon glyphicon-user"> {{Auth::user()->name}}  </h2>

<form method="post" action="/posts/update/{{$post->id}}" >
    {{csrf_field()}}
    <div class="form-group">
      <label for="title"> Title </label>
    <input type="text" value="{{ $post->title }}" name="title" class="form-control" id="title" >
    </div>
    <div class="form-group">
      <label for="body">Body</label>
      <textarea name="body"  id="body" class="form-control">{{ $post->body }}</textarea>
    </div>
    <div class="form-check">
        <button type="submit" class="btn btn-primary"> Update changes </button>
    </div>
  <input type="hidden"name="nameofpub" value="{{Auth::user()->name}}">
  </form>
  <div>
        @foreach($errors->all() as $error)
        {{ $error }} <br>
        @endforeach
    </div>
</div>


@stop