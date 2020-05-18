<?php

namespace Domain\Users\Policies;

use Domain\Users\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any roles.
     *
     * @param  \Domain\Users\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \Domain\Users\Models\User  $user
     * @param  \Domain\Users\Models\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \Domain\Users\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \Domain\Users\Models\User  $user
     * @param  \Domain\Users\Models\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \Domain\Users\Models\User  $user
     * @param  \Domain\Users\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \Domain\Users\Models\User  $user
     * @param  \Domain\Users\Models\Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \Domain\Users\Models\User  $user
     * @param  \Domain\Users\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        return false;
    }
}
