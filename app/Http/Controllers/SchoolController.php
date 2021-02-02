<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $Schools = School::get(); 
        if (count($Schools) != 0)
            return response()->json($Schools, 200);
        else
        return response()->json([
            "message" => "No Schools found"
          ], 404);
    }
    public function read($School_id)
    {
        $School = School::find($School_id); 

        if (isset($School))
            return response()->json($School , 200); 
        else 
            return response()->json([
                "message" => "Not found"
              ], 404);
    }
    public function create()
    {
    if (auth()->user()->can("create" , School::class))
    {    
        School::create(request()->validate(
            [
                'School Name' => 'required',
                'Location' => 'required',
            ])); 
        return response()->json([

            "Message" => "School Created"
        ], 201);
    }
    else 
        return response()->json([
        "Message" => "Not Authorized"
        ],403);  
    }
    public function delete($School_id)
    {
        $School = School::find($School_id); 
        if (isset($School))
        {
            if (auth()->user()->can("delete" ,$School))
            {
            $School->delete(); 
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
    public function edit($School_id)
    {
        $School = School::find($School_id); 
        if(isset($School))
        {
            if(auth()->user()->can('update' , School::find($School_id)))
            {
            $School->update(request()->validate(
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
            "Message" => "Not Authorized"
            ],403);  
        }
        else
        return response()->json([
            "message" => "Not found"
          ], 404);         
    }
}
