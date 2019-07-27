<?php

namespace App\Policies;

use App\User;
use App\Classroom;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }


    /**
     * Determine whether the user can view the classroom.
     *
     * @param User $user
     * @param Classroom $classroom
     *
     * @return mixed
     */
    public function view(User $user, Classroom $classroom)
    {
        //
    }


    /**
     * Determine whether the user can create classrooms.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }


    /**
     * Determine whether the user can update the classroom.
     *
     * @param User $user
     * @param Classroom $classroom
     *
     * @return mixed
     */
    public function update(User $user, Classroom $classroom)
    {
        //
    }


    /**
     * Determine whether the user can delete the classroom.
     *
     * @param User $user
     * @param Classroom $classroom
     *
     * @return mixed
     */
    public function delete(User $user, Classroom $classroom)
    {
        //
    }


    /**
     * Determine whether the user can restore the classroom.
     *
     * @param User $user
     * @param Classroom $classroom
     *
     * @return mixed
     */
    public function restore(User $user, Classroom $classroom)
    {
        //
    }


    /**
     * Determine whether the user can permanently delete the classroom.
     *
     * @param User $user
     * @param Classroom $classroom
     *
     * @return mixed
     */
    public function forceDelete(User $user, Classroom $classroom)
    {
        //
    }
}
