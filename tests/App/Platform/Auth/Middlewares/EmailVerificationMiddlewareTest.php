<?php

namespace Tests\App\Platform\Auth\Middlewares;

use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Providers\RouteServiceProvider;
use Support\Testing\Concerns\EmailVerificationRoutes;
use Tests\TestCase;

class EmailVerificationMiddlewareTest extends TestCase
{
    use EmailVerificationRoutes;
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Action: showVerificationNotice
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_cannot_see_the_verification_notice()
    {
        // 🙅‍♂️ No authenticated user.

        $this
            ->get($this->verificationNoticeRoute())
            ->assertRedirect(RouteServiceProvider::NOT_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: verify
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_cannot_see_the_verification_verify_route()
    {
        // 🙅‍♂️ No authenticated user.

        $this
            ->get($this->validVerificationVerifyRoute(
                User::factory()->unverified()->create()
            ))
            ->assertRedirect(RouteServiceProvider::NOT_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }

    /** @test */
    public function forbidden_is_returned_when_signature_is_invalid_in_verification_verify_route()
    {
        $user = User::factory()->verified()->create();

        $this
            ->actingAs($user)
            ->get($this->invalidVerificationVerifyRoute($user))
            ->assertForbidden();
    }

    /*
    |--------------------------------------------------------------------------
    | Action: resend
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_cannot_resend_a_verification_email()
    {
        // 🙅‍♂️ No authenticated user.

        $this
            ->post($this->verificationResendRoute())
            ->assertRedirect(RouteServiceProvider::NOT_AUTHENTICATED_MIDDLEWARE_ROUTE);
    }
}
