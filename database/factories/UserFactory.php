<?php

namespace Database\Factories;

use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

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
    public function definition()
    {
        return [
        'name' => $this->faker->firstName,
        'first_surname' => $this->faker->lastName,
        'email' => $this->faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('secret'),
        'password_changed_at' => now(),
    ];
    }

    public function verified()
    {
        return $this->state(['email_verified_at' => now()]);
    }

    public function unverified()
    {
        return $this->state(['email_verified_at' => null]);
    }

    public function mustResetPassword()
    {
        return $this->state(['password' => Hash::make(Str::random(22)), 'password_changed_at' => null, 'google_id' => null]);
    }
}
