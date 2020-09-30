<?php

namespace Tests\App\Platform\Auth\Controllers;

use Domain\Users\Models\User;
use Domain\Users\Notifications\UserRequestedVerification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Support\Testing\Concerns\EmailVerificationRoutes;
use Tests\TestCase;

/** @see \App\Platform\Auth\Controllers\EmailVerificationController */
class EmailVerificationControllerTest extends TestCase
{
    use EmailVerificationRoutes;
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Action: showVerificationNotice
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function unverified_user_can_see_the_verification_notice()
    {
        $this
            ->actingAs(User::factory()->unverified()->create())
            ->get($this->verificationNoticeRoute())
            ->assertSuccessful();
    }

    /** @test */
    public function verified_user_is_redirected_when_visiting_verification_notice_route()
    {
        $this
            ->actingAs(User::factory()->verified()->create())
            ->get($this->verificationNoticeRoute())
            ->assertRedirect($this->successfulVerificationRoute());
    }

    /*
    |--------------------------------------------------------------------------
    | Action: verify
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function user_cannot_verify_others()
    {
        $user = User::factory()->unverified()->create([
            'id' => 1,
        ]);

        $user2 = User::factory()->unverified()->create([
            'id' => 2,
        ]);

        $this
            ->actingAs($user)
            ->get($this->validVerificationVerifyRoute($user2))
            ->assertForbidden();

        $this->assertFalse($user2->fresh()->hasVerifiedEmail());
    }

    /** @test */
    public function verified_user_is_redirected_when_visiting_verification_verify_route()
    {
        $user = User::factory()->verified()->create();

        $this
            ->actingAs($user)
            ->get($this->validVerificationVerifyRoute($user))
            ->assertRedirect($this->successfulVerificationRoute());
    }

    /** @test */
    public function unverified_user_can_verify_themselves()
    {
        Event::fake();

        $user = User::factory()->unverified()->create();

        $this
            ->actingAs($user)
            ->get($this->validVerificationVerifyRoute($user))
            ->assertRedirect($this->successfulVerificationRoute());

        $this->assertNotNull($user->fresh()->email_verified_at);

        Event::assertDispatched(Verified::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: resend
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function verified_user_is_redirected_when_visiting_verification_resend_route()
    {
        $this
            ->actingAs(User::factory()->verified()->create())
            ->post($this->verificationResendRoute())
            ->assertRedirect($this->successfulVerificationRoute());
    }

    /** @test */
    public function unverified_user_can_resend_a_verification_email()
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $this
            ->actingAs($user)
            ->from($this->verificationNoticeRoute())
            ->post($this->verificationResendRoute())
            ->assertRedirect($this->verificationNoticeRoute());

        Notification::assertSentTo($user, UserRequestedVerification::class);
    }
}
