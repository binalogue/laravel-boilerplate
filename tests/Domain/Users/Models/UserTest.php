<?php

namespace Tests\Domain\Users\Models;

use Domain\Users\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Factories\UserFactory;
use Tests\TestCase;

/** @see \Domain\Users\Models\User */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | HasRoles Trait
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_can_be_scoped_by_role()
    {
        UserFactory::new()->create();
        UserFactory::new()->create()->assignRole(Role::EDITOR);
        UserFactory::new()->create()->assignRole(Role::ADMIN);
        UserFactory::new()->create()->assignRole(Role::SUPERADMIN);

        $this->assertCount(3, User::whereHasRole(Role::EDITOR)->get());
        $this->assertCount(2, User::whereHasRole(Role::ADMIN)->get());
        $this->assertCount(1, User::whereHasRole(Role::SUPERADMIN)->get());
    }

    /** @test */
    public function it_can_be_scoped_by_strict_role()
    {
        UserFactory::new()->create();
        UserFactory::new()->create()->assignRole(Role::EDITOR);
        UserFactory::new()->create()->assignRole(Role::ADMIN);
        UserFactory::new()->create()->assignRole(Role::SUPERADMIN);

        $this->assertCount(1, User::whereHasStrictRole(Role::EDITOR)->get());
        $this->assertCount(1, User::whereHasStrictRole(Role::ADMIN)->get());
        $this->assertCount(1, User::whereHasStrictRole(Role::SUPERADMIN)->get());
    }

    /** @test */
    public function it_can_be_assigned_a_role()
    {
        $user = UserFactory::new()->create()->assignRole(Role::EDITOR);

        $this->assertInstanceOf(Role::class, $user->fresh()->role);
        $this->assertEquals(Role::EDITOR, $user->fresh()->role->name);
    }

    /** @test */
    public function it_can_check_if_has_a_given_role()
    {
        $editor = UserFactory::new()->asEditor()->create();
        $admin = UserFactory::new()->asAdmin()->create();

        $this->assertTrue($editor->hasRole(Role::EDITOR));
        $this->assertTrue($admin->hasRole(Role::EDITOR));
    }

    /** @test */
    public function it_can_check_if_has_a_given_strict_role()
    {
        $editor = UserFactory::new()->asEditor()->create();
        $admin = UserFactory::new()->asAdmin()->create();

        $this->assertTrue($editor->hasStrictRole(Role::EDITOR));
        $this->assertFalse($admin->hasStrictRole(Role::EDITOR));
    }

    /*
    |--------------------------------------------------------------------------
    | SoftDeletes Trait
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $user = UserFactory::new()->create();

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
        $user = UserFactory::new()->make([
            'first_name' => 'pepe',
        ]);

        $this->assertEquals('Pepe', $user->first_name);
    }

    /** @test */
    public function it_can_get_first_name_with_accents()
    {
        $user = UserFactory::new()->make([
            'first_name' => 'álvaro',
        ]);

        $this->assertEquals('Álvaro', $user->first_name);
    }

    /** @test */
    public function it_can_get_last_name()
    {
        $user = UserFactory::new()->make([
            'last_name' => 'grillo',
        ]);

        $this->assertEquals('Grillo', $user->last_name);
    }

    /** @test */
    public function it_can_get_last_name_with_accents()
    {
        $user = UserFactory::new()->make([
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
        $user = UserFactory::new()->make([
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
        UserFactory::new()->create([
            'first_name' => 'Pepe',
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'pepe',
        ]);
    }

    /** @test */
    public function it_can_mutate_first_name_with_accents()
    {
        UserFactory::new()->create([
            'first_name' => 'Álvaro',
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'álvaro',
        ]);
    }

    /** @test */
    public function it_can_mutate_last_name()
    {
        UserFactory::new()->create([
            'last_name' => 'Grillo',
        ]);

        $this->assertDatabaseHas('users', [
            'last_name' => 'grillo',
        ]);
    }

    /** @test */
    public function it_can_mutate_last_name_with_accents()
    {
        UserFactory::new()->create([
            'last_name' => 'Álvarez',
        ]);

        $this->assertDatabaseHas('users', [
            'last_name' => 'álvarez',
        ]);
    }

    /** @test */
    public function it_can_mutate_email()
    {
        UserFactory::new()->create([
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
        $user = UserFactory::new()->asEditor()->create();

        $this->assertInstanceOf(Role::class, $user->role);
    }
}
