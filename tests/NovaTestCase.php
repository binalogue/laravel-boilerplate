<?php

namespace Tests;

use Database\Seeders\RolesTableSeeder;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Factories\UserFactory;

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
