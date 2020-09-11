<?php

namespace Database\Factories;

use Domain\Users\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'password_changed_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /*
    |----------------------------------------------------------------------
    | States
    |----------------------------------------------------------------------
    */

    public function verified(): Factory
    {
        return $this->state([
            'email_verified_at' => now(),
        ]);
    }

    public function unverified(): Factory
    {
        return $this->state([
            'email_verified_at' => null,
        ]);
    }

    public function mustResetPassword(): Factory
    {
        return $this->state([
            'password' => Hash::make(Str::random(22)),
            'password_changed_at' => null,
            'google_id' => null,
        ]);
    }

    public function trashed(): Factory
    {
        return $this->state([
            'deleted_at' => now(),
        ]);
    }

    public function asEditor(): Factory
    {
        return $this->state([
            'role_id' => Role::firstOrCreate([
                'name' => Role::EDITOR,
            ])->id,
        ]);
    }

    public function asAdmin(): Factory
    {
        return $this->state([
            'role_id' => Role::firstOrCreate([
                'name' => Role::ADMIN,
            ])->id,
        ]);
    }

    public function asSuperAdmin(): Factory
    {
        return $this->state([
            'role_id' => Role::firstOrCreate([
                'name' => Role::SUPERADMIN,
            ])->id,
        ]);
    }
}
