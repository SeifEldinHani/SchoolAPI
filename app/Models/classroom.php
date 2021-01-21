<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom extends Model
{
    protected $guarded = ["id"]; 
    protected $fillable =["classname" , "grade_id" , "School_id"];
    use HasFactory;
    
    public function Grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function Students()
    {
        return $this->hasMany(Student::class);
    }
    public function Teachers()
    {
        return $this->belongsToMany(Teacher::class); 
    }
    
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
