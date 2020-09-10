<?php

namespace Domain\Users\Policies;

use Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function update(User $user, User $model): bool
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

    public function delete(User $user, User $model): bool
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

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Additional Policies
    |--------------------------------------------------------------------------
    */

    public function updateRoleAttribute(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function updateEmailAttribute(User $user, User $model): bool
    {
        if ($model->is($user)) {
            return true;
        }

        return false;
    }

    public function updatePasswordAttribute(User $user, User $model): bool
    {
        if ($model->is($user)) {
            return true;
        }

        return false;
    }

    public function updateHasNotificationsEnabledAttribute(User $user, User $model): bool
    {
        if ($model->is($user)) {
            return true;
        }

        return false;
    }
}
