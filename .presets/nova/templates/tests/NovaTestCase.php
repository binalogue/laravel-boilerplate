<?php

namespace Tests;

use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class NovaTestCase extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('RolesTableSeeder');

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }
}
