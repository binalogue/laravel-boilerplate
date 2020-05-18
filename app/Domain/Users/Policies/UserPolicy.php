<?php

namespace Domain\Users\Policies;

use Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if (in_array($ability, [
            'delete',
            'forceDelete',
        ])) {
            return;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any users.
     *
     * @param \Domain\Users\Models\User $user
     *
     * @return bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \Domain\Users\Models\User $user
     * @param \Domain\Users\Models\User $model
     *
     * @return bool
     */
    public function view(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Domain\Users\Models\User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \Domain\Users\Models\User $user
     * @param \Domain\Users\Models\User $model
     *
     * @return bool
     */
    public function update(User $user, User $model)
    {
        if ($model->is($user)) {
            return true;
        }

        if ($model->isAdmin()) {
            return false;
        }

        if ($user->isEditor()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \Domain\Users\Models\User $user
     * @param \Domain\Users\Models\User $model
     *
     * @return bool
     */
    public function delete(User $user, User $model)
    {
        if ($model->isSuperAdmin()) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \Domain\Users\Models\User $user
     * @param \Domain\Users\Models\User $model
     *
     * @return bool
     */
    public function restore(User $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \Domain\Users\Models\User $user
     * @param \Domain\Users\Models\User $model
     *
     * @return bool
     */
    public function forceDelete(User $user, User $model)
    {
        if ($model->isSuperAdmin()) {
            return false;
        }

        if ($user->isSuperAdmin()) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Additional Policies
    |--------------------------------------------------------------------------
    */

    public function updateEmail(User $user, User $model)
    {
        if ($model->is($user)) {
            return true;
        }

        return false;
    }

    public function updatePassword(User $user, User $model)
    {
        if ($model->is($user)) {
            return true;
        }

        return false;
    }
}
