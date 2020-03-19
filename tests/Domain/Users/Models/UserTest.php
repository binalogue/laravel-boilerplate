<?php

namespace Tests\Domain\Users\Models;

use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function can_get_name()
    {
        $user = factory(User::class)->make([
            'name' => 'pepito',
        ]);

        $this->assertEquals('Pepito', $user->name);
    }

    /** @test */
    public function can_get_first_surname()
    {
        $user = factory(User::class)->make([
            'first_surname' => 'grillo',
        ]);

        $this->assertEquals('Grillo', $user->first_surname);
    }

    /** @test */
    public function can_get_second_surname()
    {
        $user = factory(User::class)->make([
            'second_surname' => 'grillo',
        ]);

        $this->assertEquals('Grillo', $user->second_surname);
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function can_mutate_name()
    {
        factory(User::class)->create([
            'name' => 'Pepito',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'pepito',
        ]);
    }

    /** @test */
    public function can_mutate_first_surname()
    {
        factory(User::class)->create([
            'first_surname' => 'Grillo',
        ]);

        $this->assertDatabaseHas('users', [
            'first_surname' => 'grillo',
        ]);
    }

    /** @test */
    public function can_mutate_second_surname()
    {
        factory(User::class)->create([
            'second_surname' => 'Grillo',
        ]);

        $this->assertDatabaseHas('users', [
            'second_surname' => 'grillo',
        ]);
    }

    /** @test */
    public function can_mutate_email()
    {
        factory(User::class)->create([
            'email' => 'PEPITO@GRILLO.COM',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'pepito@grillo.com',
        ]);
    }
}
