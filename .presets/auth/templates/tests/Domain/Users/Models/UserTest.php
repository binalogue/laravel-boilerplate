<?php

namespace Tests\Domain\Users\Models;

use Domain\Users\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see \Domain\Users\Models\User */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Use HasRoles
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_can_be_scoped_by_role()
    {
        User::factory()->create();
        User::factory()->create()->assignRole(Role::EDITOR);
        User::factory()->create()->assignRole(Role::ADMIN);
        User::factory()->create()->assignRole(Role::SUPERADMIN);

        $this->assertCount(3, User::whereHasRole(Role::EDITOR)->get());
        $this->assertCount(2, User::whereHasRole(Role::ADMIN)->get());
        $this->assertCount(1, User::whereHasRole(Role::SUPERADMIN)->get());
    }

    /** @test */
    public function it_can_be_scoped_by_strict_role()
    {
        User::factory()->create();
        User::factory()->create()->assignRole(Role::EDITOR);
        User::factory()->create()->assignRole(Role::ADMIN);
        User::factory()->create()->assignRole(Role::SUPERADMIN);

        $this->assertCount(1, User::whereHasStrictRole(Role::EDITOR)->get());
        $this->assertCount(1, User::whereHasStrictRole(Role::ADMIN)->get());
        $this->assertCount(1, User::whereHasStrictRole(Role::SUPERADMIN)->get());
    }

    /** @test */
    public function it_can_be_assigned_a_role()
    {
        $user = User::factory()->create()->assignRole(Role::EDITOR);

        $this->assertInstanceOf(Role::class, $user->fresh()->role);
        $this->assertEquals(Role::EDITOR, $user->fresh()->role->name);
    }

    /** @test */
    public function it_can_check_if_has_a_given_role()
    {
        $editor = User::factory()->asEditor()->create();
        $admin = User::factory()->asAdmin()->create();

        $this->assertTrue($editor->hasRole(Role::EDITOR));
        $this->assertTrue($admin->hasRole(Role::EDITOR));
    }

    /** @test */
    public function it_can_check_if_has_a_given_strict_role()
    {
        $editor = User::factory()->asEditor()->create();
        $admin = User::factory()->asAdmin()->create();

        $this->assertTrue($editor->hasStrictRole(Role::EDITOR));
        $this->assertFalse($admin->hasStrictRole(Role::EDITOR));
    }

    /*
    |--------------------------------------------------------------------------
    | Use SoftDeletes
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->trashed());

        $user->delete();

        $this->assertTrue($user->trashed());

        $user->restore();

        $this->assertFalse($user->trashed());
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_can_get_first_name()
    {
        $user = User::factory()->make([
            'first_name' => 'pepe',
        ]);

        $this->assertEquals('Pepe', $user->first_name);
    }

    /** @test */
    public function it_can_get_first_name_with_accents()
    {
        $user = User::factory()->make([
            'first_name' => 'álvaro',
        ]);

        $this->assertEquals('Álvaro', $user->first_name);
    }

    /** @test */
    public function it_can_get_last_name()
    {
        $user = User::factory()->make([
            'last_name' => 'grillo',
        ]);

        $this->assertEquals('Grillo', $user->last_name);
    }

    /** @test */
    public function it_can_get_last_name_with_accents()
    {
        $user = User::factory()->make([
            'last_name' => 'álvarez',
        ]);

        $this->assertEquals('Álvarez', $user->last_name);
    }

    /*
    |--------------------------------------------------------------------------
    | Additional Getters
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_can_get_full_name()
    {
        $user = User::factory()->make([
            'first_name' => 'pepe',
            'last_name' => 'grillo',
        ]);

        $this->assertEquals('Pepe Grillo', $user->full_name);
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_can_mutate_first_name()
    {
        User::factory()->create([
            'first_name' => 'Pepe',
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'pepe',
        ]);
    }

    /** @test */
    public function it_can_mutate_first_name_with_accents()
    {
        User::factory()->create([
            'first_name' => 'Álvaro',
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'álvaro',
        ]);
    }

    /** @test */
    public function it_can_mutate_last_name()
    {
        User::factory()->create([
            'last_name' => 'Grillo',
        ]);

        $this->assertDatabaseHas('users', [
            'last_name' => 'grillo',
        ]);
    }

    /** @test */
    public function it_can_mutate_last_name_with_accents()
    {
        User::factory()->create([
            'last_name' => 'Álvarez',
        ]);

        $this->assertDatabaseHas('users', [
            'last_name' => 'álvarez',
        ]);
    }

    /** @test */
    public function it_can_mutate_email()
    {
        User::factory()->create([
            'email' => 'PEPE@GRILLO.COM',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'pepe@grillo.com',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_belongs_to_a_role()
    {
        $user = User::factory()->asEditor()->create();

        $this->assertInstanceOf(Role::class, $user->role);
    }
}
