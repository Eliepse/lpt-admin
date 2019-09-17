<?php

namespace App\Policies;

use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;


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
     * @return mixed
     */
    public function view(User $user, Course $course)
    {
        return false;
    }


    /**
     * @param User $user
     * @param Course $course
     *
     * @return mixed
     */
    public function viewAny(User $user, Course $course)
    {
        return false;
    }


    /**
     * Determine whether the user can create courses.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }


    /**
     * Determine whether the user can update the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        return false;
    }


    /**
     * Determine whether the user can delete the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the course.
     *
     * @param User $user
     * @param Course $course
     *
     * @return mixed
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
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        return false;
    }
}