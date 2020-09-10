<?php

namespace Tests\App\Platform\Auth\Middlewares;

use Domain\Users\Models\User;
use Support\Providers\RouteServiceProvider;
use Support\Testing\Concerns\SocialiteRoutes;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class SocialiteMiddlewareTest extends TestCase
{
    use SocialiteRoutes;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->make();
    }

    /*
    |--------------------------------------------------------------------------
    | Action: redirectToProvider
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function auth_user_cannot_see_the_redirect_to_provider_route()
    {
        $this
            ->actingAs($this->user)
            ->get($this->socialiteRedirectRoute())
            ->assertRedirect(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }
}
