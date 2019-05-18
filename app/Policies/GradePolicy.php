<?php

namespace App\Policies;

use App\User;
use App\Grade;
use Illuminate\Auth\Access\HandlesAuthorization;

class GradePolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }


    /**
     * Determine whether the user can view the grade.
     *
     * @param  \App\User $user
     * @param  \App\Grade $grade
     * @return mixed
     */
    public function view(User $user, Grade $grade)
    {
        return $user->isTeacher();
    }


    /**
     * Determine whether the user can create grades.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }


    /**
     * Determine whether the user can update the grade.
     *
     * @param  \App\User $user
     * @param  \App\Grade $grade
     * @return mixed
     */
    public function update(User $user, Grade $grade)
    {
        //
    }


    /**
     * Determine whether the user can delete the grade.
     *
     * @param  \App\User $user
     * @param  \App\Grade $grade
     * @return mixed
     */
    public function delete(User $user, Grade $grade)
    {
        //
    }


    /**
     * Determine whether the user can restore the grade.
     *
     * @param  \App\User $user
     * @param  \App\Grade $grade
     * @return mixed
     */
    public function restore(User $user, Grade $grade)
    {
        //
    }


    /**
     * Determine whether the user can permanently delete the grade.
     *
     * @param  \App\User $user
     * @param  \App\Grade $grade
     * @return mixed
     */
    public function forceDelete(User $user, Grade $grade)
    {
        //
    }
}
