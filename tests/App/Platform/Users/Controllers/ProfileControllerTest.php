<?php

namespace Tests\App\Platform\Users\Controllers;

use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_user_can_not_view_profile_page()
    {
        $response = $this->get(route('profile.show'));

        $response->assertRedirect(route('login.form'));
    }

    /** @test */
    public function user_that_must_reset_password_can_not_view_profile_page()
    {
        $user = factory(User::class)
            ->state('must_reset_password')
            ->create();

        $response = $this
            ->actingAs($user)
            ->get(route('profile.show'));

        $response->assertRedirect(route('password.forceReset'));
    }

    /** @test */
    public function unverified_user_can_not_view_profile_page()
    {
        $user = factory(User::class)
            ->state('unverified')
            ->create();

        $response = $this
            ->actingAs($user)
            ->get(route('profile.show'));

        $response->assertRedirect(route('verification.notice'));
    }

    /** @test */
    public function auth_user_can_view_profile_page()
    {
        $user = factory(User::class)
            ->state('verified')
            ->state('has_completed_quiz')
            ->create();

        $response = $this
            ->actingAs($user)
            ->get(route('profile.show'));

        $response
            ->assertSuccessful();
    }
}
