@extends('master')

@section('content') 
<style>
    .table-condensed{
  font-size: 24px;
  background-color:azure;
  outline: solid 2px #377bb5;
  outline-offset: -2px;
    
}
    </style>
    <div class="col-md-8">
        <h1 class="page-header">
                Statistics
                <small> Website Statistics </small>
        </h1>
         </div>
              <table class="table table-condensed">
                  <tr>
                      <td>  All Users  </td>
                      <td> {{$statics['users']}} </td>
                  </tr>
                  <tr>
                      <td>  All Posts  </td>
                      <td> {{$statics['posts']}}</td>
                  </tr>
                  <tr>
                      <td> All Comments  </td>
                      <td> {{ $statics['comments'] }}</td>
                  </tr>
                  <tr>
                        <td> Most Acive User </td>
                        <td> <b>{{$statics['acive_user']}}</b>,likes({{$statics['acive_user_likes']}}),Comment({{$statics['acive_user_comments']}})</td>
                    </tr>
                    <tr>
                            <td> Most Acive Post </td>
                            <tr>
                            <td> {{$statics['acive_post_title']}}</td>
                            </tr>
                   
                    <tr>
                    <td>{{$statics['acive_post_body']}} </td>
                </tr>
            </tr>
                   
              </table>
         </div>
    </div>
 
@stop