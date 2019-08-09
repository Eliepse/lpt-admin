<?php

namespace App\Policies;

use App\User;
use App\StaffUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffUserPolicy
{
    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }


    /**
     * Determine whether the user can view any staff users.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }


    /**
     * Determine whether the user can view the staff user.
     *
     * @param \App\User $user
     * @param \App\StaffUser $staffUser
     *
     * @return mixed
     */
    public function view(User $user, StaffUser $staffUser)
    {
        //
    }


    /**
     * Determine whether the user can create staff users.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }


    /**
     * Determine whether the user can update the staff user.
     *
     * @param \App\User $user
     * @param \App\StaffUser $staffUser
     *
     * @return mixed
     */
    public function update(User $user, StaffUser $staffUser)
    {
        //
    }


    /**
     * Determine whether the user can delete the staff user.
     *
     * @param \App\User $user
     * @param \App\StaffUser $staffUser
     *
     * @return mixed
     */
    public function delete(User $user, StaffUser $staffUser)
    {
        //
    }


    /**
     * Determine whether the user can restore the staff user.
     *
     * @param \App\User $user
     * @param \App\StaffUser $staffUser
     *
     * @return mixed
     */
    public function restore(User $user, StaffUser $staffUser)
    {
        //
    }


    /**
     * Determine whether the user can permanently delete the staff user.
     *
     * @param \App\User $user
     * @param \App\StaffUser $staffUser
     *
     * @return mixed
     */
    public function forceDelete(User $user, StaffUser $staffUser)
    {
        //
    }
}
