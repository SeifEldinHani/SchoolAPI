<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $guarded = ["id"]; 
    protected $fillable =["gradename" , "School_id"];
    public function classrooms()
    {
        return $this->hasMany(classroom::class); 
    }
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
