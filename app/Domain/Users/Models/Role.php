<?php

namespace Domain\Users\Models;

use Domain\Users\Contracts\Role as RoleContract;
use Domain\Users\Exceptions\RoleDoesNotExist;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * A role belongs to some users.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Static
    |--------------------------------------------------------------------------
    */

    public static function findByName(string $name): RoleContract
    {
        $role = static::where('name', $name)->first();

        if (!$role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    public static function findById(int $id): RoleContract
    {
        $role = static::where('id', $id)->first();

        if (!$role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }

    public static function findOrCreate(string $name): RoleContract
    {
        $role = static::where('name', $name)->first();

        if (!$role) {
            return static::query()->create([
                'name' => $name,
            ]);
        }

        return $role;
    }
}
