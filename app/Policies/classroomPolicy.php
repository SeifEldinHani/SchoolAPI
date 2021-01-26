<?php

namespace App\Policies;

use App\Models\User;
use App\Models\classroom;
use Illuminate\Auth\Access\HandlesAuthorization;

class classroomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role == 'admin' || $user->role == 'teacher' ; 
    }
    public function setAttendance(User $user , Classroom $classroom)
    {
        return $classroom->user->contains($user); 
    }
    public function getStudents(User $user , Classroom $classroom)
    {
        return $classroom->user->contains($user);
    }
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\classroom  $classroom
     * @return mixed
     */
    public function view(User $user, classroom $classroom)
    {
        if ($user->role == 'admin')
        
            return true; 
        
        else if ($user->role == 'teacher')
        
           return $classroom->user->contains($user); 
        
        else 
           return false; 
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role == 'admin'; 
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\classroom  $classroom
     * @return mixed
     */
    public function update(User $user, classroom $classroom)
    {
        return $user->role == 'admin'; 
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\classroom  $classroom
     * @return mixed
     */
    public function delete(User $user, classroom $classroom)
    {
        return $user->role == 'admin'; 
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\classroom  $classroom
     * @return mixed
     */
    public function restore(User $user, classroom $classroom)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\classroom  $classroom
     * @return mixed
     */
    public function forceDelete(User $user, classroom $classroom)
    {
        //
    }
}
