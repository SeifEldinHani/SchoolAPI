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
        {
            $teachers = User::where("role" , "teacher")->get(); 
            if (count($teachers) != 0)
                return response()->json($teachers , 200); 
            else 
                return response()->json(["message" => "No teachers found"] , 404);
        }

        else 
            return response()->json([
                "Message" => "Not Authorized"
            ],403); 
    }
    public function read($teacher_id)
    {

        $user = User::find($teacher_id);
        if (isset($user) && $user->role == "teacher")

            if (auth()->user()->can("viewAny" , Teacher::class))
                return response()->json($user, 200); 
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
        $classroom = classroom::find($classroom_id); 
        $Teacher = User::find($Teacher_id);
        if (isset($classroom) && isset($Teacher) && $Teacher->role == "teacher")
        {
        if(auth()->user()->can("setClassroom", Teacher::class) && !$Teacher->classrooms->contains($classroom))
        {
            $Teacher->classrooms()->attach($classroom_id);  
            $Teacher->schools()->attach($classroom->School_id);
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
        $classroom = classroom::find($class_id);
        if(isset($classroom))
        {
            if (auth()->user()->can('getStudents' , $classroom)) 
                return response()->json($classroom->students);
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
        $classroom = classroom::find($class_id);
        if (isset($classroom) && $classroom->students->contains(Student::find($student_id)))
            $student = Student::find($student_id);
        else
            return response()->json([
                "message" => "Not found"
              ], 404); 

        $req = request()->validate([
            'Attendance' => 'required|boolean', 
            'date' => 'required|date'
        ]); 

        if (auth()->user()->can("setAttendance" ,$classroom ))
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
