<?php

namespace Domain\Users\Concerns;

use Domain\Users\Contracts\Role as RoleContract;
use Domain\Users\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait UserHasRoles
{
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The roles that belong to the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope the model query to certain roles only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array|\Domain\Users\Contracts\Role|\Illuminate\Support\Collection $roles
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole(Builder $query, $roles): Builder
    {
        if ($roles instanceof Collection) {
            $roles = $roles->all();
        }

        if (! is_array($roles)) {
            $roles = [$roles];
        }

        $roles = array_map(function ($role) {
            if ($role instanceof RoleContract) {
                return $role;
            }

            $method = is_numeric($role) ? 'findById' : 'findByName';

            return Role::{$method}($role);
        }, $roles);

        return $query->whereHas('roles', function ($query) use ($roles) {
            $query->where(function ($query) use ($roles) {
                foreach ($roles as $role) {
                    $query->orWhere('roles.id', $role->id);
                }
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Custom
    |--------------------------------------------------------------------------
    */

    /**
     * Assign the given roles to the model.
     *
     * @param array|string|\App\Permission\Contracts\Role ...$roles
     *
     * @return $this
     */
    public function assignRole(...$roles)
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                if (empty($role)) {
                    return false;
                }

                return $this->getStoredRole($role);
            })
            ->filter(function ($role) {
                return $role instanceof RoleContract;
            })
            ->map->id
            ->all();

        $this->roles()->sync($roles, false);

        return $this;
    }

    /**
     * Revoke the given role from the model.
     *
     * @param string|\Domain\Users\Contracts\Role $role
     */
    public function removeRole($role)
    {
        $this->roles()->detach($this->getStoredRole($role));

        return $this;
    }

    /**
     * Remove all current roles and set the given ones.
     *
     * @param array|\Domain\Users\Contracts\Role|string ...$roles
     *
     * @return $this
     */
    public function syncRoles(...$roles)
    {
        $this->roles()->detach();

        return $this->assignRole($roles);
    }

    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param string|int|array|\Domain\Users\Contracts\Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if (is_int($roles)) {
            return $this->roles->contains('id', $roles);
        }

        if ($roles instanceof RoleContract) {
            return $this->roles->contains('id', $roles->id);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return $roles->intersect($this->roles)->isNotEmpty();
    }

    /**
     * Determine if the model has all of the given role(s).
     *
     * @param string|array|\Domain\Users\Contracts\Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasAllRoles($roles): bool
    {
        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if ($roles instanceof RoleContract) {
            return $this->roles->contains('id', $roles->id);
        }

        $roles = collect()->make($roles)->map(function ($role) {
            return $role instanceof RoleContract ? $role->name : $role;
        });

        return $roles->intersect($this->getRoleNames()) == $roles;
    }

    /**
     * Get model role names.
     *
     * @return Collection
     */
    public function getRoleNames(): Collection
    {
        return $this->roles->pluck('name');
    }

    /**
     * Determine if a user is super admin.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPERADMIN);
    }

    /**
     * Determine if a user is admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole([
            Role::ADMIN,
            Role::SUPERADMIN,
        ]);
    }

    /**
     * Determine if a user is editor.
     *
     * @return bool
     */
    public function isEditor(): bool
    {
        return $this->hasRole([
            Role::EDITOR,
            Role::ADMIN,
            Role::SUPERADMIN,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Protected
    |--------------------------------------------------------------------------
    */

    /**
     * @param string|int $role
     *
     * @return RoleContract
     */
    protected function getStoredRole($role): RoleContract
    {
        if (is_numeric($role)) {
            return Role::findById($role);
        }

        if (is_string($role)) {
            return Role::findByName($role);
        }

        return $role;
    }
}
