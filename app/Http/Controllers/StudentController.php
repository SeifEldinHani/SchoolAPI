<?php

namespace App\Http\Controllers;
use App\Models\attendance;
use App\Models\classroom;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = auth()->user()->Students;
        if (count($students) != 0)
            return response()->json($students , 200); 
        else
            return response()->json([
                "message" => "No avaliable Students"
            ] , 404); 

    }
    public function read($student_id)
    {
        $Student = Student::find($student_id); 
        if (isset($Student))

            if (auth()->user()->can("view" , $Student))
                return response()->json(auth()->user()->Students()->find($student_id) , 200);

            else
                return response()->json([
                "Message" => "Not Authorized"
                ],403);  
                
        else
            return response()->json([
                "message" => "Not Found"
            ] , 404); 
    }
    public function create()
    {
        $temp = request()->validate(
            [
                'name' => 'required',
                'sex' => 'required',
                'age' =>'required' ,
                'classroom_id' => ['required','exists:classrooms,id'],
            ]);
            
        $grade_id = classroom::find(request('classroom_id'))->grade_id;  
        $School_id = classroom::find(request('classroom_id'))->School_id;  

        if (auth()->user()->can('create' , Student::class))
        {
            auth()->user()->students()->create([
                'name' => $temp['name'], 
                'sex' => $temp['sex'],
                'age' => $temp['age'],
                'classroom_id' => $temp['classroom_id'], 
                'grade_id' => $grade_id , 
                'School_id' => $School_id,
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
    public function delete($student_id)
    {
        $Student = Student::find($student_id); 
        if (isset($Student))
        {
            if (auth()->user()->can('delete' , $Student))
            {
                $Student->delete();
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
    public function edit($student_id)
    {
        $Student = Student::find($student_id); 
        if (isset($Student))
        {
            $temp = request()->validate(
                [
                    'name' => 'required',
                    'sex' => 'required',
                    'age' =>'required' ,
                    'classroom_id' => ['required','exists:classrooms,id']
                ]);
                
                $grade_id = classroom::find(request('classroom_id'))->grade_id;  
                $School_id = classroom::find(request('classroom_id'))->School_id; 

                if (auth()->user()->can('update' , Student::find($student_id)))
                {
                    $Student->update([
                        'name' => $temp['name'], 
                        'sex' => $temp['sex'],
                        'age' => $temp['age'],
                        'classroom_id' => $temp['classroom_id'], 
                        'grade_id' => $grade_id , 
                        'School_id' => $School_id
                    ]); 

                    return response()->json([
                        "Message" => "Upadted"
                    ] , 200);
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
}
