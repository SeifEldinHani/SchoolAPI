<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;
    protected $guarded = ["id"]; 
    protected $fillable = ["student_id" , "student_name" , "Attendance" ,"date"]; 
    public function student()
    {
        return $this->belongsTo(student::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
