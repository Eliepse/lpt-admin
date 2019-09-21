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
     * @param User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }


    /**
     * Determine whether the user can view the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return mixed
     */
    public function view(User $user, StaffUser $staffUser)
    {
        return false;
    }


    /**
     * Determine whether the user can create staff users.
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
     * Determine whether the user can update the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return mixed
     */
    public function update(User $user, StaffUser $staffUser)
    {
        return $user->is($staffUser);
    }


    /**
     * Determine whether the user can update the password of the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return mixed
     */
    public function updatePassword(User $user, StaffUser $staffUser)
    {
        return $user->is($staffUser);
    }


    /**
     * Determine whether the user can delete the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return mixed
     */
    public function delete(User $user, StaffUser $staffUser)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return mixed
     */
    public function restore(User $user, StaffUser $staffUser)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return mixed
     */
    public function forceDelete(User $user, StaffUser $staffUser)
    {
        return false;
    }
}
