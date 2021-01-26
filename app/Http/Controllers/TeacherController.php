<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\classroom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        if (auth()->user()->can("viewAny" , Teacher::class))
            return response()->json(User::where("role" , "teacher")->get(), 200); 
        else 
            return response()->json([
                "Message" => "Not Authorized"
            ],403); 
    }
    public function read($teacher_id)
    {

        if (User::where('id' , $teacher_id)->exists() &&  User::find($teacher_id)->role == "teacher")

            if (auth()->user()->can("viewAny" , Teacher::class))
                return response()->json(User::find($teacher_id), 200); 
            else 
                return response()->json([
                    "Message" => "Not Authorized"
                ],403);
            else{
                    return response()->json([
                        "Message" => "Not Found"
                    ],404); 
                }                
                
    }
    public function setClassroom($Teacher_id , $classroom_id)
    {
        if (classroom::where("id" , $classroom_id)->exists() && (User::where('id' , $Teacher_id)->exists() && User::find($Teacher_id)->role == "teacher"))
        {
        if(auth()->user()->can("setClassroom", Teacher::class) && !User::find($Teacher_id)->classrooms->contains(classroom::find($classroom_id)))
        {
            User::find($Teacher_id)->classrooms()->attach($classroom_id);  
            User::find($Teacher_id)->schools()->attach(classroom::find($classroom_id)->School_id);
            return response()->json([
                "Message" => "Classroom set"
            ] , 201); 
        }
        else 
            return response()->json([
                "Message" => "Not Authorized"
            ],403); 
        }
        else{
            return response()->json([
                "Message" => "Not Found"
            ],404); 
        }

    }
    public function getStudents($class_id)
    {
        if(classroom::where('id' , $class_id)->exists())
        {
            if (auth()->user()->can('getStudents' , classroom::find($class_id))) 
                return response()->json(classroom::find($class_id)->students);
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
    public function attendance($class_id , $student_id)
    {

        if (classroom::where("id" , $class_id)->exists() && classroom::find($class_id)->students->contains(Student::find($student_id)) )
            $student = classroom::find($class_id)->first()->students->find($student_id); 
        else
            return response()->json([
                "message" => "Not found"
              ], 404); 

        $req = request()->validate([
            'Attendance' => 'required|boolean', 
            'date' => 'required|date'
        ]); 

        if (auth()->user()->can("setAttendance" ,classroom::find($class_id)))
        {
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
        else
            return response()->json([
                "Message" => "Not Authorized"
            ],403);  
}
}
