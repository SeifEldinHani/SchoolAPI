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
        if(classroom::where('id' , $class_id)->exists())
        {
        if (auth()->user()->can('view' ,classroom::find($class_id)))
            return response()->json(auth()->user()->classrooms()->find($class_id), 200);

        else 
            return response()->json([
                "Message" => "Not Authorized"
            ],403); 
        }
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
        $School_id = Grade::find(request('grade_id'))->School_id;

        if (auth()->user()->can('create' , classroom::class))
        {
            classroom::create(  
            [
                'classname' => $temp['classname'], 
                'grade_id' => $temp['grade_id'],
                'School_id' => $School_id
            ]); 
            return response()->json([
                "Message" => "Created"
            ], 201); 
        }
        else 
            return response()->json([
                "Message" => "Not Authorized"
            ],403); 

    }
    public function delete($class_id)
    {
        if(classroom::where("id" , $class_id)->exists())
        {
            if (auth()->user()->can('delete' ,classroom::find($class_id)))
            {
                classroom::find($class_id)->delete();
                return response()->json([
                    "message" => "Deleted"
                  ], 202);
            }
            else
                return response()->json([
                    "Message" => "Not Authorized"
                ],403);  
        }
        
        else
        return response()->json([
            "message" => "Not found"
          ], 404);

    }
    public function edit($class_id)
    {
        if(classroom::where("id" , $class_id)->exists())
        {
            if (auth()->user()->can('update' ,classroom::find($class_id)))
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
            {
                return response()->json([
                    "Message" => "Not Authorized"
                ],403);  
            }
        }
        else
            return response()->json([
                "message" => "Not found"
              ], 404);
    }}
