<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parentt extends Model
{
    use HasFactory;
    protected $guarded = ["id"]; 
    protected $fillable = ["name" , "sex" , "age"]; 
    public function students()
    {
        return $this->hasMany(Student::class); 
    }
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
