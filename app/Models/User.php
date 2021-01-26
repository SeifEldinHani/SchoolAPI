<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

 
class User extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'age',
        'sex',
        'role',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function parents()
    {
        return $this->hasMany(Parentt::class); 
    }
    public function classrooms()
    {
        return $this->belongsToMany(classroom::class); 
    }
    public function grades()
    {
        return $this->hasMany(Grade::class); 
    }
    public function schools()
    {
        return $this->belongsToMany(School::class); 
    }
    public function students()
    {
        return $this->hasMany(Student::class); 
    }
    public function teachers()
    {
        return $this->hasMany(Teacher::class); 
    }
    public function attendances()
    {
        return $this->hasMany(attendance::class); 
    }
}
