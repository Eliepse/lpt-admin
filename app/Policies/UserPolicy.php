<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * @param User $model
     *
     * @return mixed
     */
    public function viewAny()
    {
        return false;
    }


    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return false;
    }


    /**
     * Determine whether the user can create models.
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
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return false;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return false;
    }


    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return false;
    }
}
