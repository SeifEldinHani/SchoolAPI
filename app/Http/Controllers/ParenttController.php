<?php

namespace App\Http\Controllers;

use App\Models\Parentt;
use Illuminate\Http\Request;

class ParenttController extends Controller
{
    public function index()
    {
        $parent = auth()->user()->parents;
        return response()->json($parent, 200);
    }
    public function read($Parent_Id)
    {
        if(auth()->user()->parents()->where('id' , $Parent_Id)->exists())
            return response()->json(auth()->user()->parents()->find($Parent_Id), 200);
        else
        return response()->json([
            "message" => "Not found"
          ], 404);
    } 
    public function create()
    {
        auth()->user()->parents()->create(request()->validate(
            [
                'name' => 'required',
                'sex' => 'required',
                'age' =>'required', 
            ])); 
        return response()->json([
            "Message" => "Created"
        ], 201); 
        
    }
    public function delete($Parent_Id)
    {
        if(auth()->user()->parents()->where('id' , $Parent_Id)->exists())
        {
            auth()->user()->parents()->find($Parent_Id)->delete();
        return response()->json([
            "message" => "Deleted"
          ], 202);
        }
        else
        return response()->json([
            "message" => "Not found"
          ], 404);

    }
    public function edit($Parent_Id)
    {
        if(auth()->user()->parents()->where('id' , $Parent_Id)->exists()) 
        {
            auth()->user()->parents()->find($Parent_Id)->update(request()->validate(
            [
                'name' => 'required',
                'sex' => 'required',
                'age' =>'required', 
            ]));
            return response()->json([
                "message" => "Updated"
              ], 200);      
        }
        else
        return response()->json([
            "message" => "Not found"
          ], 404);
    }
}
