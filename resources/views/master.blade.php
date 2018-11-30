<!DOCTYPE html>
<html lang="en">

<head>
       

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="Soltan" content="">
    <meta id="token" name="token" content="{ { csrf_token() } }">

    <title>FCI Commuity</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link  href="{{ asset('css/blog-home.css') }}" rel="stylesheet">


<style>
    html,body{
        background: url(../images/minimal-background-pattern-wordpress-1.jpg) no-repeat 0px 0px;
    background-size: cover;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    -ms-background-size: cover;
    background-attachment: fixed;
    }

    hr{
        border:none;
        height:2px;
        color:#ccc;
        background-color: #ccc;
    }
    .comment
    {
        border: 2px solid #ccc;
        padding: 10px;
    }
    
</style>
</head>

<body>

  
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">FCI Community</a>
            </div>
          
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if(Auth::check())
                    @if(Auth::user()->hasRole('professor'))
                    <li>
                        <a href="/admin">Admin</a>
                    </li>
                    @endif
                    <li>
                            <a href="/posts">Posts</a>
                    </li>

                   
                    

                    @if(Auth::user()->hasRole('professor')||Auth::user()->hasRole('student_aff'))
                    <li>
                        <a href="/prof">Add Post</a>
                    </li>
                    @endif
                    <li>
                            <a>Welcome : {{Auth::user()->name}}</a>
                    </li>
                    <li>
                            <a href="/logout">Logout</a>
                    </li>
                    @else
                    <li>
                            <a href="/register">Regiter</a>
                    </li>
                    <li>
                            <a href="/login">Login</a>
                    </li>
                    @endif
                </ul>
            </div>
          
        </div>
       
    </nav>

  
    <div class="container">

        <div class="row">

          
            <div class="col-md-8">

              @yield('content')
            </div>
        </div>
      
      

    </div>
    <script  src="{{ asset('js/jquery.js') }}"></script>

   
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script  src="{{ asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{url('/js/like.js')}}"></script>

<script type="text/javascript">
    var url="{{route('like')}}";
    var url_dis="{{route('dislike')}}";
    var token="{{Session::token()}}";
</script>

</body>

</html>
