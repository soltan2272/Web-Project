<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts',[
    'uses'=>'PagesController@posts',
    'as'=>'content.posts',
    'middleware'=>'roles',
    'roles'=>['professor','student','student_aff']
]
);
Route::get('posts/{post}','PagesController@post');
Route::post('posts/store','PagesController@store');
//Route::post('posts/storef','PagesController@storef');
//prof



Route::group(['middleware'=>'roles', 'roles'=>['professor','student_aff']],function(){
    Route::get('/prof','PagesController@prof');
    Route::get('/posts/{post}','PagesController@delete');
    Route::get('/posts/edit/{post}','PagesController@edit');
    Route::post('/posts/update/{post}','PagesController@update');

});

Route::group(['middleware'=>'roles', 'roles'=>['professor']],function(){
    Route::get('admin','PagesController@admin');
    Route::post('add-role','PagesController@addrole');

});
Route::group(['middleware'=>'roles', 'roles'=>['student','professor','student_aff']],function(){
    Route::post('/like','PagesController@like')->name('like');
    Route::post('/dislike','PagesController@dislike')->name('dislike');
});



Route::post('posts/{post}/store','CommentsController@store');

Route::get('category/{name}','PagesController@category');

//auth

Route::get('/register','RegisterationController@create');
Route::post('/register','RegisterationController@store');

Route::get('/login','SessionsController@create');
Route::post('/login','SessionsController@store');

Route::get('/logout','SessionsController@destroy');
