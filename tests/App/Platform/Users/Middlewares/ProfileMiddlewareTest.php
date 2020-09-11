<?php

namespace Tests\App\Platform\Users\Middlewares;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Providers\RouteServiceProvider;
use Support\Testing\Concerns\EmailVerificationRoutes;
use Support\Testing\Concerns\ForceResetPasswordRoutes;
use Tests\TestCase;

class ProfileMiddlewareTest extends TestCase
{
    use EmailVerificationRoutes;
    use ForceResetPasswordRoutes;
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_see_their_profile()
    {
        $this
            ->get(route('profile.show'))
            ->assertRedirect(RouteServiceProvider::NOT_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }

    /** @test */
    public function unverified_user_can_not_see_their_profile()
    {
        $this
            ->actingAs(UserFactory::new()->unverified()->create())
            ->get(route('profile.show'))
            ->assertRedirect($this->verificationNoticeRoute());
    }

    /** @test */
    public function user_that_must_reset_password_can_not_see_their_profile()
    {
        $this
            ->actingAs(UserFactory::new()->mustResetPassword()->create())
            ->get(route('profile.show'))
            ->assertRedirect($this->forceResetPasswordRoute());
    }
}
