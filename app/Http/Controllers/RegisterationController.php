<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use DB;

class RegisterationController extends Controller
{
    public function create()
    {
        $stop_register=DB::table('settings')->where('name','stop_register')->value('value');
        return view('register',compact('stop_register'));
    }
    public function store(Request $request)
    {
        $this->validate(request(),[
            'name'=>'required|min:5',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
        ]);
        //create user
        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        //user role
        $user->roles()->attach(Role::where('name','student')->first());

        //login
        auth()->login($user);

        //redirect
        return redirect('/posts');
    }
}
