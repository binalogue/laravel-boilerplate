<?php

namespace Tests\App\Platform\Auth\Middlewares;

use Domain\Users\Models\User;
use Support\Providers\RouteServiceProvider;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class LoginMiddlewareTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->make();
    }

    /*
    |--------------------------------------------------------------------------
    | Action: showLoginForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function auth_user_cannot_see_the_login_form()
    {
        $this
            ->actingAs($this->user)
            ->get(RouteServiceProvider::LOGIN_ROUTE)
            ->assertRedirect(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: login
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function auth_user_cannot_login()
    {
        $this
            ->actingAs($this->user)
            ->post(RouteServiceProvider::LOGIN_ROUTE)
            ->assertRedirect(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }
}
