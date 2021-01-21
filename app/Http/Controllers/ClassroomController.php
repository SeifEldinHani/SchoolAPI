<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classroom = auth()->user()->classrooms;
        return response()->json($classroom, 200);
    }
    public function read($class_id)
    {
        if(auth()->user()->classrooms()->where('id' , $class_id)->exists())
            return response()->json(auth()->user()->classrooms()->find($class_id), 200);
        else
        return response()->json([
            "message" => "Not found"
          ], 404);
    }
    public function create()
    {
        
        $temp = request()->validate(
            [
                'classname' => 'required',
                'grade_id' => ['required' , "exists:grades,id"]
            ]); 
        $School_id = auth()->user()->grades()->where('id', request('grade_id'))->first()->School_id;
        auth()->user()->classrooms()->create(  
        [
            'classname' => $temp['classname'], 
            'grade_id' => $temp['grade_id'],
            'School_id' => $School_id
        ]
        ); 
        return response()->json([
            "Message" => "Created"
        ], 201); 
        
    }
    public function delete($class_id)
    {
        if(auth()->user()->classrooms()->where('id' , $class_id)->exists())
        {
        auth()->user()->classrooms()->find($class_id)->delete();
        return response()->json([
            "message" => "Deleted"
          ], 202);
        }
        else
        return response()->json([
            "message" => "Not found"
          ], 404);

    }
    public function edit($class_id)
    {
        if(auth()->user()->classrooms()->where('id' , $class_id)->exists()) 
        {
            auth()->user()->classrooms()->find($class_id)->update(request()->validate(
            [
                'classname' => 'required',
                'grade_id' => ['required' , "exists:grades,id"]
            ]));
            return response()->json([
                "message" => "Updated"
              ], 200);      
        }
        else
        return response()->json([
            "message" => "Not found"
          ], 404);
    }}
