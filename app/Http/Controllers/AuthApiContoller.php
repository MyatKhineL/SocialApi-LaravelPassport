<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthApiContoller extends Controller
{
    public function index(){
        $users = User::all();
        return $users;
    }

    public function register(Request $request){

        $request->validate([
            'name'=>'required|min:3',
            'email'=>'required',
            'password'=>'required|min:4',
            'image'=>'required|file|mimes:jpg,png',
        ]);
        if($request->file('image')) {
            $image_name = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs("public/images", $image_name);
        }


            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->image = $image_name;

            $user->save();


            //create token
            $token = $user->createToken('social')->accessToken;
            return response()->json([
                'status'=>200,
                'message'=>'success',
                'data'=>$user,
                'token'=>$token
            ]);


    }

    public function login(Request  $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required|min:4',
        ]);

        $email=$request->email;
        $password = $request->password;

        $cre = ['email'=>$email,'password'=>$password];

        if(Auth::attempt($cre)){
            $user = Auth::user();
            $token = $user->createToken('social')->accessToken;
            return response()->json([
                'status'=>200,
                'message'=>'success',
                'data'=>$user,
                 'token'=>$token
            ]);
        }
        return response()->json([
            'status'=>500,
            'message'=>'fail',
            'data'=>[
                'error'=>"email_and_password_don't_match"
            ]
        ]);
    }
}
