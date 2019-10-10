<?php

namespace App\Policies;

use App\Sets\UserRolesSet;
use App\User;
use App\Family;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyPolicy
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
     * Determine whether the user can view any families.
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
     * Determine whether the user can view the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return bool
     */
    public function view(User $user, Family $family)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can create families.
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
     * Determine whether the user can update the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return bool
     */
    public function update(User $user, Family $family)
    {
        if ($user->hasRoles([UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can delete the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return bool
     */
    public function delete(User $user, Family $family)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return bool
     */
    public function restore(User $user, Family $family)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return bool
     */
    public function forceDelete(User $user, Family $family)
    {
        return false;
    }


    /**
     * @param User $user
     * @return bool
     */
    public function createChild(User $user)
    {
        return false;
    }
}
