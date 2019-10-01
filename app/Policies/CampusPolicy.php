<?php

namespace App\Policies;

use App\Campus;
use App\Sets\UserRolesSet;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampusPolicy
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
     * @param Campus $campus
     *
     * @return mixed
     */
    public function viewAny(User $user, Campus $campus)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can view the course.
     *
     * @param User $user
     * @param Campus $campus
     *
     * @return mixed
     */
    public function view(User $user, Campus $campus)
    {
        if ($user->hasRoles([UserRolesSet::TEACHER, UserRolesSet::MANAGER])) {
            return true;
        }

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
     * @param Campus $campus
     *
     * @return mixed
     */
    public function update(User $user, Campus $campus)
    {
        if ($user->hasRoles([UserRolesSet::MANAGER])) {
            return true;
        }

        return false;
    }


    /**
     * Determine whether the user can delete the course.
     *
     * @param User $user
     * @param Campus $campus
     *
     * @return mixed
     */
    public function delete(User $user, Campus $campus)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the course.
     *
     * @param User $user
     * @param Campus $campus
     *
     * @return mixed
     */
    public function restore(User $user, Campus $campus)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param User $user
     * @param Campus $campus
     *
     * @return mixed
     */
    public function forceDelete(User $user, Campus $campus)
    {
        return false;
    }
}
