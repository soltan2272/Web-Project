@extends('master')

@section('content')

<div class="col-md-8">
    

        <h3>Sign Up!!</h3>
        @if($stop_register==1)
        <h3 color:red;> Oops!!! Registeration Closed !!!</h3>
        @else

        <form method="post" action="/register">
            {{ csrf_field() }}
    
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control form-app" placeholder="Full Name">
            </div>
    
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control form-app" placeholder="Email Address">
            </div>
    
            <div class="form-group">
                <label for="password">Pawword</label>
                <input type="password" name="password" class="form-control form-app" placeholder="Pawword">
            </div>
    
            <div class="form-group">
                <button type="submit" class="btn btn-submit">Sign Up</button>
            </div>
    
        </form>
        <div>
                @foreach($errors->all() as $error)
                {{ $error }} <br>
                @endforeach
                @endif
            </div>
</div>

@stop