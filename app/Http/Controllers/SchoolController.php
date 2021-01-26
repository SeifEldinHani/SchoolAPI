<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $Schools = School::get(); 
        return response()->json($Schools, 200);
    }
    public function read($School_id)
    {
        if (School::where("id" , $School_id)->exists())
        {
            $School = School::find($School_id); 
            return response()->json($School , 200);
        }
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
        if (School::where("id" , $School_id)->exists())
        {
            if (auth()->user()->can("delete" , School::find($School_id)))
            {
            auth()->user()->schools()->find($School_id)->delete();
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
        if(School::where('id' , $School_id)->exists() && auth()->user()->can('update' , School::find($School_id)))
        {
            School::find($School_id)->update(request()->validate(
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
}
