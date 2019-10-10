<?php

namespace App\Policies;

use App\Sets\UserRolesSet;
use App\User;
use App\StaffUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffUserPolicy
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
     * Determine whether the user can view any staff users.
     *
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
     * Determine whether the user can view the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return bool
     */
    public function view(User $user, StaffUser $staffUser)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can create staff users.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can update the staff user.
     *
     * @param User $user
     * @param StaffUser $staffUser
     *
     * @return bool
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
     * @return bool
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
     * @return bool
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
     * @return bool
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
     * @return bool
     */
    public function forceDelete(User $user, StaffUser $staffUser)
    {
        return false;
    }
}
