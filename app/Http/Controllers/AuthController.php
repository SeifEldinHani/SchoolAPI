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
            'age' => 'required', 
            'sex' => 'required', 
            'role' => 'required', 
            'email' => "required|email|unique:users",
            'password' => "required|min:8",
        ]);


        $user = User::create([

            'name' => $valid['name'] , 
            'email' => $valid['email'] , 
            'age' => $valid['age'],
            'sex' => $valid['sex'],
            'role' => $valid['role'], 
            'password' => bcrypt($valid['password'])
        ]);
 
        return response()->json(['Message' => "User Registered"], 200);
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
             return response()->json(['error' => 'Login Failed'], 401);
         }
    }
 
    public function details(){
        return response()->json(['user' => auth()->user()], 200);
        
    }
    public function delete($User_id)
    {
        if (User::where("id" , $User_id)->exists())
        {
        User::find($User_id)->delete(); 
        return response()->json([
            "Message" => "Deleted"
        ], 202);
        }

    }
}
