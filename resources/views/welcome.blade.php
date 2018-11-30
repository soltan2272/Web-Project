<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FCI Commuity</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link  href="{{ asset('css/blog-home.css') }}" rel="stylesheet">


<style>
    html,body{
        background: url(../images/410119501Website-Design-Background.jpg) no-repeat 0px 0px;
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
    a:link, a:visited {
    background-color: #f44336;
    color: white;
    padding: 14px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}


a:hover, a:active {
    background-color: red;
}
#reg
 {
    background-color:greenyellow;
}
</style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a style="background-color:black;" class="navbar-brand" href="#">FCI Community</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                        @if(Auth::check())

                        @if(Auth::user()->hasRole('professor'))
                    <li>
                        <a  style="background-color:black;" href="/admin">Admin</a>
                    </li>
                    @endif
                    <li>
                        <a style="background-color:black;" href="/posts">Posts</a>
                    </li>
                    @if(Auth::user()->hasRole('professor')||Auth::user()->hasRole('student_aff'))
                    <li>
                        <a  style="background-color:black;" href="/prof">Add Post</a>
                    </li>
                    @endif
                   
                    <li>
                            <a style="background-color:black;">Welcome : {{Auth::user()->name}}</a>
                    </li>
                    <li>
                            <a style="background-color:black;" href="/logout">Logout</a>
                    </li>
                    @else
                    <li>
                            <a style="background-color:black;" href="/register">Regiter</a>
                    </li>
                    <li>
                            <a style="background-color:black;" href="/login">Login</a>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        
        
        <!-- /.container -->
    </nav>
    
    <div style="text-align: center; margin-top: 200px;
    margin-bottom: 100px;
    margin-right: 150px;
    margin-left: 150px;
    font-size:100px;" class="row justify-content-center">
    @if(Auth::check())
            <div class="col-lg-12 text-white bg-dark" >
                FCI Community
            </div>
   @else
   <div class="col-lg-12 text-white bg-dark" >
        FCI Community
    </div>
        <a  href="/login" style="font-size:50px;"> Login </a>
            <a id="reg" href="register" style="font-size:40px;"> Register </a>
            
            <!-- /.col-lg-12 -->
        </div>
        @endif
    
</body>

</html>
