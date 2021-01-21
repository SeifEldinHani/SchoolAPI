<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $Schools = auth()->user()->schools;
        return response()->json($Schools, 200);

    }
    public function read($School_id)
    {
        if(auth()->user()->schools()->where('id' , $School_id)->exists())
            return response()->json(auth()->user()->schools()->find($School_id), 200);
        else
        return response()->json([
            "message" => "School not found"
          ], 404);
    }
    public function create()
    {
        auth()->user()->schools()->create(request()->validate(
            [
                'School Name' => 'required',
                'Location' => 'required',
            ])); 
        return response()->json([

            "Message" => "School Created"
        ], 201);
    }
    public function delete($School_id)
    {
        if(auth()->user()->schools()->where('id' , $School_id)->exists())
        {
            auth()->user()->schools()->find($School_id)->delete();
            return response()->json([
                "message" => "Deleted"
              ], 202);
        }
        else
            return response()->json([
            "message" => "Not found"
          ], 404);

    }
    public function edit($School_id)
    {
        if(auth()->user()->schools()->where('id' , $School_id)->exists())
        {
            auth()->user()->schools()->find($School_id)->update(request()->validate(
                [
                    'School Name' => 'required',
                    'Location' => 'required',

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
    public function getTeachers($School_id)
    {
        return response()->json(auth()->user()->schools()->find($School_id)->Teachers, 200);
    }
    public function getStudents($School_id)
    {
        return response()->json(auth()->user()->schools()->find($School_id)->Students, 200);
    }
}
