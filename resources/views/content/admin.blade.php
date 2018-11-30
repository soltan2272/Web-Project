@extends('master')

@section('content')
<style>
    table {
    border-collapse: collapse;
    width: 100%;
    height:100%
    align:center;

}

th, td {
    text-align: left;
    padding: 8px;
    background-color:white;
    font-weight: bold;
}


th {
    background-color: #4CAF50;
    color: white;
}

    </style>
    <h2 style=" color:brown;font-size:60px;"  class="	glyphicon glyphicon-user"> {{Auth::user()->name}}  </h2>
<div class="col-md-16">
    <h4 style=" color:blue;font-size:40px;"> Control Panel </h4><hr>
    <h4 style=" color:orange;font-size:30px;"> List of users </h4>

<div>
<table  class="table table-hover" >
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Student</th>
        <th>Student_Affair</th>
        <th>Professor</th>
    </tr>
    @foreach($users as $user)
    <form action="/add-role" method="post">
        {{csrf_field()}}
    <input type="hidden" name="email" value="{{$user->email}}">
    <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->name}} </td>
        <td>{{$user->email}}</td>
    <td> <input type="checkbox" onchange="this.form.submit()" name="role_std" {{$user->hasRole('student')?'checked':' '}}> </td>
    <td> <input type="checkbox" onchange="this.form.submit()" name="role_std_aff" {{$user->hasRole('student_aff')?'checked':' '}}> </td>
    <td> <input type="checkbox" onchange="this.form.submit()" name="role_prof" {{$user->hasRole('professor')?'checked':' '}}> </td>
    </tr>
</form>
    @endforeach
</table>
</div>

</div>
@stop