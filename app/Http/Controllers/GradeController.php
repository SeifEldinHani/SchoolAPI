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
        if (auth()->user()->grades()->where("id" , $grade_id)->exists())
        return response()->json(auth()->user()->grades()->find($grade_id) , 200);
        else
        return response()->json([
            "message" => "Not found"
        ], 404); 
    }
    public function create()
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
    public function delete($grade_id)
    {
        if (auth()->user()->grades()->where("id" , $grade_id)->exists())
        auth()->user()->grades()->find($grade_id)->delete();
        
        else
            return response()->json([
                "message" => "Not found"
            ], 404); 

    }
    public function edit($grade_id)
    {
        if (auth()->user()->grades()->where("id" , $grade_id)->exists())
        auth()->user()->grades()->find($grade_id)->update(request()->validate(
            [
                'gradename' => 'required',
                'School_id' => ['required', 'exists:schools,id']
            ]));
        else
            return response()->json([
                "message" => "Not found"
            ], 404); 
            
    }
    public function getclasses($grade_id)
    {
        if (auth()->user()->grades()->where("id" , $grade_id)->exists())
        return auth()->user()->grades()->find($grade_id)->classrooms;
        else
        return response()->json([
            "message" => "Not found"
        ], 404); 

    }
}
