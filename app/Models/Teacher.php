<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = ["id"]; 
    protected $fillable =["name" , "sex" , "age" , "classroom_id" , "School_id"];
    use HasFactory;

    public function classrooms()
    {
        return $this->belongsToMany(classroom::class);
    }
    public function School()
    {
    return $this->belongsTo(School::class); 
    }
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
