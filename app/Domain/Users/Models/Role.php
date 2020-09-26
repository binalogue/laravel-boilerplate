<?php

namespace Domain\Users\Models;

use Domain\Users\Contracts\Role as RoleContract;
use Domain\Users\Exceptions\RoleDoesNotExist;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Eloquent\Model;

class Role extends Model implements RoleContract
{
    public const SUPERADMIN = 'superadmin';
    public const ADMIN = 'admin';
    public const EDITOR = 'editor';

    /*
    |--------------------------------------------------------------------------
    | Eloquent
    |--------------------------------------------------------------------------
    */

    protected $guarded = ['id'];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Static
    |--------------------------------------------------------------------------
    */

    public static function findByName(string $name): self
    {
        $role = static::where('name', $name)->first();

        if (! $role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    public static function findById(int $id): self
    {
        $role = static::where('id', $id)->first();

        if (! $role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }

    public static function findOrCreate(string $name): self
    {
        $role = static::where('name', $name)->first();

        if (! $role) {
            return static::query()->create([
                'name' => $name,
            ]);
        }

        return $role;
    }
}
