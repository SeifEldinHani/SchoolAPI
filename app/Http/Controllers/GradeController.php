<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grade = auth()->user()->grades;
        return response()->json($grade , 200); 

    }
    public function read($grade_id)
    {
        if (Grade::where("id" , $grade_id)->exists())
        {
            if (auth()->user()->can("view" , Grade::class))
                return response()->json(auth()->user()->grades()->find($grade_id) , 200);
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
        if (auth()->user()->can("create" , Grade::class)) 
        {
            auth()->user()->grades()->create(request()->validate(
            [
                'gradename' => 'required',
                'School_id' => ['required', 'exists:schools,id']
            ])); 
        
        return response()->json(
            [
                "message" => "Grade Created"
            ]
            , 201); 
        }
        else
            return response()->json([
                "message" => "Not Authorized"
            ], 403);  


    }
    public function delete($grade_id)
    {
        if (Grade::where('id' , $grade_id))
        {
            if (auth()->user()->can("delete" , Grade::class))
            {
            Grade::find($grade_id)->delete();
            return response()->json([
                "message" => "Deleted"
              ], 202);
            }
            else
                return response()->json([
                    "message" => "Not found"
                ], 404);   
            
        }
        else
            return response()->json([
                "message" => "Not found"
            ], 404); 

    }
    public function edit($grade_id)
    {
        if (Grade::where("id" , $grade_id)->exists())
        {
            if (auth()->user()->can("update" , Grade::class))

                Grade::find($grade_id)->update(request()->validate(
                [
                    'gradename' => 'required',
                    'School_id' => ['required', 'exists:schools,id']
                ]));
            else
                return response()->json([
                    "message" => "Not found"
                ], 404);  

        }
        else
            return response()->json([
                "message" => "Not found"
            ], 404); 
            
    }
}
