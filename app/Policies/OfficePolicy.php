<?php

namespace App\Policies;

use App\Office;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfficePolicy
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
     * @param Office $office
     *
     * @return mixed
     */
    public function viewAny(User $user, Office $office)
    {
        return false;
    }


    /**
     * Determine whether the user can view the classroom.
     *
     * @param User $user
     * @param Office $office
     *
     * @return mixed
     */
    public function view(User $user, Office $office)
    {
        return false;
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
        return false;
    }


    /**
     * Determine whether the user can update the classroom.
     *
     * @param User $user
     * @param Office $office
     *
     * @return mixed
     */
    public function update(User $user, Office $office)
    {
        return false;
    }


    /**
     * Determine whether the user can delete the classroom.
     *
     * @param User $user
     * @param Office $office
     *
     * @return mixed
     */
    public function delete(User $user, Office $office)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the classroom.
     *
     * @param User $user
     * @param Office $office
     *
     * @return mixed
     */
    public function restore(User $user, Office $office)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the classroom.
     *
     * @param User $user
     * @param Office $office
     *
     * @return mixed
     */
    public function forceDelete(User $user, Office $office)
    {
        return false;
    }
}
