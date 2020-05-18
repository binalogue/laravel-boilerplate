<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Domain\Users\Models\User;
use Faker\Generator as Faker;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'first_surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('secret'),
        'password_changed_at' => now(),
    ];
});

$factory->state(User::class, 'verified', [
    'email_verified_at' => now(),
]);

$factory->state(User::class, 'unverified', [
    'email_verified_at' => null,
]);

$factory->state(User::class, 'must_reset_password', [
    'password' => Hash::make(Str::random(22)),
    'password_changed_at' => null,
    'facebook_id' => null,
    'google_id' => null,
]);
