<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(){

 
        $valid = request()->validate([
            'name' => "required",
            'email' => "required|email|unique:users",
            'password' => "required|min:8",
        ]);


        $user = User::create([

            'name' => $valid['name'] , 
            'email' => $valid['email'] , 
            'password' => bcrypt($valid['password'])
        ]);
 
        $token = $user->createToken('Token')->accessToken;
 
        return response()->json(['token' => $token], 200);
    }
 
    public function login(){
        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
         ];
 
         if(Auth::attempt($credentials)){
             $token = Auth::user()->createToken('Token')->accessToken;
             return response()->json(['token' => $token], 200);
         }else{
             return response()->json(['error' => 'UnAuthorized'], 401);
         }
    }
 
    public function details(){
        return response()->json(['user' => auth()->user()], 200);
        
    }

    public function test()
    {
        return response()->json([
            "Test" =>"Done"
        ]); 
    }
    
    public function test1()
    {
        return response()->json([
            "Test1" =>"Done"
        ]); 
    }
}
