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
     * @param  \App\User $user
     * @param  \App\Course $course
     * @return mixed
     */
    public function view(User $user, Course $course)
    {
        return $user->isTeacher();
    }


    /**
     * Determine whether the user can create courses.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }


    /**
     * Determine whether the user can update the course.
     *
     * @param  \App\User $user
     * @param  \App\Course $course
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        //
    }


    /**
     * Determine whether the user can delete the course.
     *
     * @param  \App\User $user
     * @param  \App\Course $course
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        //
    }


    /**
     * Determine whether the user can restore the course.
     *
     * @param  \App\User $user
     * @param  \App\Course $course
     * @return mixed
     */
    public function restore(User $user, Course $course)
    {
        //
    }


    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param  \App\User $user
     * @param  \App\Course $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        //
    }
}