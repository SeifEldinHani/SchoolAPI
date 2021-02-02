<?php

namespace App\Http\Controllers;

use App\Models\Parentt;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class ParenttController extends Controller
{
    public function setSchool($Parent_id , $school_id)
    { 
        $School = School::find($school_id); 
        $User = User::find($Parent_id); 
        
        if ((isset($School) && isset($User)) && $User->role == "parent")
        {
        if(auth()->user()->can("SetSchool", Parentt::class) && !$User->schools->contains($School))
        {
            $User->schools()->attach($school_id);  
            return response()->json([
                "Message" => "School set"
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
    public function getStudents()
    {

        if(auth()->user()->can("ViewAny", Parentt::class))
        return response()->json(["Students"=>auth()->user()->students] , 200); 
        else 
        return response()->json([
            "Message" => "Not Authorized"
        ],403); 
    }
    public function getStudentAttendance($student_id)
    {
        $student = Student::find($student_id);
        if (isset($student))
        {
        if (auth()->user()->can('view' ,$student , Parentt::class))
        {
            return response()->json($student->attendance, 200); 
        }

        else
        return response()->json([
            "Message" => "Not Authorized"
        ],403);  
        }
    else
    return response()->json([
        "Message" => "Not Found"
    ],404); 
    }
}
