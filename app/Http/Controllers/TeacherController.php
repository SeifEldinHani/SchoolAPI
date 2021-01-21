<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\classroom;
use App\Models\Student;
use App\Models\Teacher; 
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function index()
    {
        $Teacher = auth()->user()->teachers;
        return response()->json($Teacher, 200);
    }


    public function read(Teacher $Teacher_id)
    {
        if(auth()->user()->teachers()->where('id' , $Teacher_id)->exists())
            return response()->json(auth()->user()->teachers()->find($Teacher_id), 200);
        else
        return response()->json([
            "message" => "Not found"
          ], 404);
    }

    public function create()
    {
        auth()->user()->teachers()->create(request()->validate(
            [
                'name' => 'required',
                'sex' => 'required',
                'age' =>'required', 
                'School_id' => ['required' , 'exists:schools,id'] 
            ])); 
        return response()->json([
            "message" => "Created"
          ], 201);
    }
    public function setClassroom($Teacher_id , $classroom_id)
    {
        if(auth()->user()->teachers()->where('id' , $Teacher_id)->exists() && auth()->user()->classrooms()->where('id' , $classroom_id)->exists() )
        {
            auth()->user()->teachers()->find($Teacher_id)->classrooms()->attach($classroom_id);  
            return response()->json([
                "Message" => "Classroom set"
            ] , 200); 
        }
        else
            return response()->json([
            "message" => "Not found"
          ], 404);

    }
    public function delete($Teacher_id)
    {
        if(auth()->user()->teachers()->where('id' , $Teacher_id)->exists())
        {
            auth()->user()->teachers()->find($Teacher_id)->delete();
            return response()->json([
                "message" => "Deleted"
              ], 202);
        }
        else
            return response()->json([
            "message" => "Not found"
          ], 404);

    }
    public function edit($Teacher_id)
    {
        if(auth()->user()->teachers()->where('id' , $Teacher_id)->exists()){
            auth()->user()->teachers()->find($Teacher_id)->update(request()->validate(
                [
                'name' => 'required',
                'sex' => 'required',
                'age' =>'required'

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

    public function getStudents($Teacher_id , $class_id)
    {
        if(auth()->user()->teachers()->where('id' , $Teacher_id)->exists())
        return response()->json(auth()->user()->teachers()->find($Teacher_id)->classrooms->where('id' , $class_id)->first()->Students, 200);


        else
        return response()->json([
            "message" => "Not found"
          ], 404);
    }
    public function attendance($Teacher_id  , $class_id , $student_id)
    {
        if(auth()->user()->teachers()->where('id' , $Teacher_id)->exists() && auth()->user()->students()->where('id' , $student_id)->exists() && auth()->user()->classrooms()->where('id' , $class_id)->exists()){
        $student = auth()->user()->teachers()->find($Teacher_id)->classrooms->find($class_id)->first()->students->find($student_id)->first(); 

        $req = request()->validate([
            'Attendance' => 'required|boolean', 
            'date' => 'required|date'
        ]); 


        auth()->user()->attendances()->create(
            [
                'student_id' => $student->id, 
                'student_name' => $student->name,
                'Attendance' => $req['Attendance'],
                'date' => $req['date']
            ]
        ); 
        return response()->json([
            "Message" => "Attendance Created"
        ], 201); 
    }

    else{
        return response()->json([
            "message" => "Not found"
          ], 404);
    }


    }
}
