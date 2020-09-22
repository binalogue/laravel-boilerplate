<?php

namespace Tests\App\Platform\Auth\Middlewares;

use Domain\Users\Models\User;
use Support\Providers\RouteServiceProvider;
use Support\Testing\Concerns\RegistrationRoutes;
use Tests\TestCase;

class RegisterMiddlewareTest extends TestCase
{
    use RegistrationRoutes;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->make();
    }

    /*
    |--------------------------------------------------------------------------
    | Action: showRegisterForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function auth_user_cannot_see_the_registration_form()
    {
        $this
            ->actingAs($this->user)
            ->get($this->registerGetRoute())
            ->assertRedirect(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: register
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function auth_user_cannot_register()
    {
        $this
            ->actingAs($this->user)
            ->post($this->registerPostRoute())
            ->assertRedirect(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }
}
