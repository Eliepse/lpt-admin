<?php

namespace App\Policies;

use App\Sets\UserRolesSet;
use App\User;
use App\Student;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;


    /**
     * @param User $user
     * @param $ability
     *
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }


    /**
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can view the student.
     *
     * @param User $user
     * @param Student $student
     *
     * @return bool
     */
    public function view(User $user, Student $student)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can create students.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->hasRoles([UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can update the student.
     *
     * @param User $user
     * @param Student $student
     *
     * @return bool
     */
    public function update(User $user, Student $student)
    {
        if ($user->hasRoles([UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can delete the student.
     *
     * @param User $user
     * @param Student $student
     *
     * @return bool
     */
    public function delete(User $user, Student $student)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the student.
     *
     * @param User $user
     * @param Student $student
     *
     * @return bool
     */
    public function restore(User $user, Student $student)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the student.
     *
     * @param User $user
     * @param Student $student
     *
     * @return bool
     */
    public function forceDelete(User $user, Student $student)
    {
        return false;
    }
}
