<?php

namespace Tests\Factories;

use Domain\Users\Models\Role;
use Domain\Users\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Support\Testing\Factory;

class UserFactory extends Factory
{
    protected string $modelClass = User::class;

    public function create(array $extra = []): User
    {
        return parent::build($extra);
    }

    public function make(array $extra = []): User
    {
        return parent::build($extra, 'make');
    }

    public function getDefaults(Faker $faker): array
    {
        return [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
        ];
    }

    /*
    |----------------------------------------------------------------------
    | States
    |----------------------------------------------------------------------
    */

    public function verified(): self
    {
        return tap(clone $this)->overwriteDefaults([
            'email_verified_at' => now(),
        ]);
    }

    public function unverified(): self
    {
        return tap(clone $this)->overwriteDefaults([
            'email_verified_at' => null,
        ]);
    }

    public function trashed(): self
    {
        return tap(clone $this)->overwriteDefaults([
            'deleted_at' => now(),
        ]);
    }

    public function asEditor(): self
    {
        return tap(clone $this)->overwriteDefaults([
            'role_id' => Role::firstOrCreate([
                'name' => Role::EDITOR,
            ])->id,
        ]);
    }

    public function asAdmin(): self
    {
        return tap(clone $this)->overwriteDefaults([
            'role_id' => Role::firstOrCreate([
                'name' => Role::ADMIN,
            ])->id,
        ]);
    }

    public function asSuperAdmin(): self
    {
        return tap(clone $this)->overwriteDefaults([
            'role_id' => Role::firstOrCreate([
                'name' => Role::SUPERADMIN,
            ])->id,
        ]);
    }
}
