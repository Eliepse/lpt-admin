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
     * Determine whether the user can view the classroom.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function view(User $user, Schedule $schedule)
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
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function update(User $user, Schedule $schedule)
    {
        //
    }


    /**
     * Determine whether the user can delete the classroom.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function delete(User $user, Schedule $schedule)
    {
        //
    }


    /**
     * Determine whether the user can restore the classroom.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function restore(User $user, Schedule $schedule)
    {
        //
    }


    /**
     * Determine whether the user can permanently delete the classroom.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function forceDelete(User $user, Schedule $schedule)
    {
        //
    }


    /**
     * Determine whether the user can update the classroom.
     *
     * @param User $user
     * @param Schedule $schedule
     *
     * @return mixed
     */
    public function updateStudents(User $user, Schedule $schedule)
    {
        //
    }
}
