<?php

namespace Tests;

use Database\Factories\UserFactory;
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

        $this->user = UserFactory::new()->create();
        $this->actingAs($this->user);
    }
}
