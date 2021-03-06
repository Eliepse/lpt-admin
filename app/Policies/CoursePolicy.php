<?php

namespace App\Policies;

use App\Sets\UserRolesSet;
use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;


    /**
     * @param User $user
     * @param string $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }


    /**
     * Determine whether the user can view the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return bool
     */
    public function view(User $user, Course $course)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
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
     * Determine whether the user can create courses.
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
     * Determine whether the user can update the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return bool
     */
    public function update(User $user, Course $course)
    {
        if ($user->hasRoles([UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can delete the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return bool
     */
    public function delete(User $user, Course $course)
    {
        if ($user->hasRoles([UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can restore the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return bool
     */
    public function restore(User $user, Course $course)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return bool
     */
    public function forceDelete(User $user, Course $course)
    {
        return false;
    }
}
