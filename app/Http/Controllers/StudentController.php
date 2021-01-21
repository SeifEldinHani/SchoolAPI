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
        return response()->json($students , 200); 

    }
    public function read($student_id)
    {
        if (auth()->user()->Students()->where('id' , $student_id)->exists())
            return response()->json(auth()->user()->Students()->find($student_id) , 200);
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
                'parentt_id' => ['required','exists:parentts,id']
            ]);
            
        $grade_id = auth()->user()->classrooms()->find(request('classroom_id'))->first()->grade_id;  
        $School_id = auth()->user()->classrooms()->find(request('classroom_id'))->first()->School_id;     
        
        auth()->user()->students()->create([
            'name' => $temp['name'], 
            'sex' => $temp['sex'],
            'age' => $temp['age'],
            'classroom_id' => $temp['classroom_id'], 
            'grade_id' => $grade_id , 
            'School_id' => $School_id,
            'parentt_id' => $temp["parentt_id"]
        ]); 

        return response()->json([
            "Message" => "Created"
        ], 201); 

    }
    public function delete($student_id)
    {
        if (auth()->user()->Students()->where('id' , $student_id)->exists())
        {
            auth()->user()->Students()->find($student_id)->delete();
            return response()->json([
                "message" => "Deleted"
              ], 202);
        }
        else
            return response()->json([
            "message" => "Not found"
          ], 404);
    }
    public function edit($student_id)
    {
        if (auth()->user()->Students()->where('id' , $student_id)->exists())
        {
            $temp = request()->validate(
                [
                    'name' => 'required',
                    'sex' => 'required',
                    'age' =>'required' ,
                    'classroom_id' => ['required','exists:classrooms,id'],
                    'parentt_id' => ['required','exists:parentt,id']
                ]);
                
                $grade_id = auth()->user()->classrooms()->find(request('classroom_id'))->first()->grade_id;  
                $School_id = auth()->user()->classrooms()->find(request('classroom_id'))->first()->School_id;    
            
                auth()->user()->Students()->find($student_id)->update([
                    'name' => $temp['name'], 
                    'sex' => $temp['sex'],
                    'age' => $temp['age'],
                    'classroom_id' => $temp['classroom_id'], 
                    'parentt_id' => $temp['parentt_id'], 
                    'grade_id' => $grade_id , 
                    'School_id' => $School_id
                ]); 

        return response()->json([
            "Message" => "Upadted"
        ] , 200);
        }
        else
        return response()->json([
            "message" => "Not found"
          ], 404);
    }
    public function getAttendance($student_id)
    {
        if(auth()->user()->Students()->where('student_id' , $student_id)->exists())
        {
        $at =  auth()->user()->attendances()->where('student_id' , $student_id)->get(); 
        return $at; 
        }
        else{
            return response()->json([
                "message" => "Not found"
              ], 404);
        }

    }
}
