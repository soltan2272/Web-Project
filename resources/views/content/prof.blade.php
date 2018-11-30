@extends('master')

@section('content')


<h2 style=" color:brown;font-size:60px;"  class="	glyphicon glyphicon-user"> {{Auth::user()->name}}  </h2>

<form method="post" action="/posts/store" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="form-group">
      <label for="title"> Title </label>
      <input type="text" name="title" class="form-control" id="title"  placeholder="Enter Title">
    </div>
    <div class="form-group">
      <label for="body">Body</label>
      <textarea name="body" id="body" class="form-control"></textarea>
    </div>
    <div class="form-group">
            <label for="url">Image</label>
            <input id="url" type="file" name="url">
    </div>
    <div class="form-check">
        <button type="submit" class="btn btn-primary"> Add Post </button>
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