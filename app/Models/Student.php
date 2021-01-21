<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = ["id"]; 
    protected $fillable =["name" , "sex" , "age" , "classroom_id" , "School_id" , "grade_id" , "parentt_id"];
    public function classrooms()
    {
        return $this->belongsTo(Classroom::class); 
    }
    public function attendance()
    {
        return $this->hasMany(attendance::class);
    }
    public function School()
    {
        return $this->belongsTo(Student::class); 
    }
    public function Parentt()
    {
        return $this->belongsTo(Parentt::class); 
    }
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}