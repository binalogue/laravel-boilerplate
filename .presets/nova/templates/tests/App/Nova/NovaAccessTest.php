<?php

namespace Tests\App\Nova;

use Domain\Users\Models\Role;
use Tests\NovaTestCase;

class NovaAccessTest extends NovaTestCase
{
    /** @test **/
    public function basic_user_doesnt_have_access_to_nova()
    {
        $this
            ->get("/nova-api/users/{$this->user->id}")
            ->assertForbidden();
    }

    /** @test **/
    public function editor_has_access_to_nova()
    {
        $this->user->assignRole(Role::EDITOR);

        $this
            ->get("/nova-api/users/{$this->user->id}")
            ->assertSuccessful();
    }

    /** @test **/
    public function admin_has_access_to_nova()
    {
        $this->user->assignRole(Role::ADMIN);

        $this
            ->get("/nova-api/users/{$this->user->id}")
            ->assertSuccessful();
    }

    /** @test **/
    public function superadmin_has_access_to_nova()
    {
        $this->user->assignRole(Role::SUPERADMIN);

        $this
            ->get("/nova-api/users/{$this->user->id}")
            ->assertSuccessful();
    }
}
