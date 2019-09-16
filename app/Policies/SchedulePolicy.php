<?php

namespace App\Policies;

use App\User;
use App\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }


    /**
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function viewAny(User $user, Schedule $schedule)
    {
        return false;
    }


    /**
     * Determine whether the user can view the course.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function view(User $user, Schedule $schedule)
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
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function update(User $user, Schedule $schedule)
    {
        return false;
    }


    /**
     * Determine whether the user can delete the course.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function delete(User $user, Schedule $schedule)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the course.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function restore(User $user, Schedule $schedule)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function forceDelete(User $user, Schedule $schedule)
    {
        return false;
    }


    /**
     * Determine whether the user can update the course.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function updateStudents(User $user, Schedule $schedule)
    {
        return false;
    }
}
