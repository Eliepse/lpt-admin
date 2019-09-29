<?php

namespace App\Policies;

use App\User;
use App\Family;
use Illuminate\Auth\Access\HandlesAuthorization;

class FamilyPolicy
{
    use HandlesAuthorization;


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
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }


    /**
     * Determine whether the user can view the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return mixed
     */
    public function view(User $user, Family $family)
    {
        return false;
    }


    /**
     * Determine whether the user can create families.
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
     * Determine whether the user can update the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return mixed
     */
    public function update(User $user, Family $family)
    {
        return false;
    }


    /**
     * Determine whether the user can delete the family.
     *
     * @param User $user
     * @param Family $family
     *
     * @return mixed
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
     * @return mixed
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
     * @return mixed
     */
    public function forceDelete(User $user, Family $family)
    {
        return false;
    }


    public function createChild()
    {
        return false;
    }
}
