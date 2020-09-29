<?php

namespace Domain\Users\Concerns;

use Domain\Users\Contracts\Role as RoleContract;
use Domain\Users\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRoles
{
    protected function mapRoles(string $role): array
    {
        switch ($role) {
            case Role::SUPERADMIN:
                return [
                    Role::SUPERADMIN,
                ];
            case Role::ADMIN:
                return [
                    Role::ADMIN,
                    Role::SUPERADMIN,
                ];
            case Role::EDITOR:
                return [
                    Role::EDITOR,
                    Role::ADMIN,
                    Role::SUPERADMIN,
                ];
            default:
                return [];
        }
    }

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

    protected function matchesRole($roles): bool
    {
        if (! $this->role) {
            return false;
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->matchesRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return $this->role->name === $roles;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeWhereHasRole(Builder $query, string $role)
    {
        return $query->whereHas('role', function (Builder $query) use ($role) {
            $query->whereIn('name', $this->mapRoles($role));
        });
    }

    public function scopeWhereHasStrictRole(Builder $query, string $role)
    {
        return $query->whereHas('role', function (Builder $query) use ($role) {
            $query->where('name', $role);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Custom
    |--------------------------------------------------------------------------
    */

    public function assignRole($role): self
    {
        $role = Role::findOrCreate($role);

        $this->role()->associate($this->getStoredRole($role))->save();

        return $this;
    }

    public function hasRole(string $role): bool
    {
        return $this->matchesRole($this->mapRoles($role));
    }

    public function hasStrictRole(string $role): bool
    {
        return $this->matchesRole($role);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPERADMIN);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ADMIN);
    }

    public function isEditor(): bool
    {
        return $this->hasRole(Role::EDITOR);
    }
}
