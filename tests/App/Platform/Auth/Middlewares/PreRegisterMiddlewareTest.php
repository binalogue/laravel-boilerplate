<?php

namespace Tests\App\Platform\Auth\Middlewares;

use Domain\Users\Models\User;
use Support\Providers\RouteServiceProvider;
use Support\Testing\Concerns\RegistrationRoutes;
use Tests\TestCase;

class PreRegisterMiddlewareTest extends TestCase
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
    | Action: showPreRegisterForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function auth_user_cannot_see_the_pre_register_form()
    {
        $this
            ->actingAs($this->user)
            ->get($this->registerPreRoute())
            ->assertRedirect(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }
}
