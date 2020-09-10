<?php

namespace Tests\App\Platform\Auth\Controllers;

use Domain\Users\Notifications\UserForgotPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Support\Testing\Concerns\ForgotPasswordRoutes;
use Tests\Factories\UserFactory;
use Tests\TestCase;

/** @see \App\Platform\Auth\Controllers\ForgotPasswordController */
class ForgotPasswordControllerTest extends TestCase
{
    use ForgotPasswordRoutes;
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Action: showLinkRequestForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_can_see_the_link_request_form()
    {
        // 🙅‍♂️ No authenticated user.

        $this
            ->get($this->passwordRequestRoute())
            ->assertSuccessful();
    }

    /** @test */
    public function auth_user_can_see_the_link_request_form()
    {
        $this
            ->actingAs(UserFactory::new()->make())
            ->get($this->passwordRequestRoute())
            ->assertSuccessful();
    }

    /*
    |--------------------------------------------------------------------------
    | Action: sendResetLinkEmail
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function user_doesnt_receive_email_when_not_registered()
    {
        Notification::fake();

        $this
            ->from($this->passwordRequestRoute())
            ->post($this->passwordEmailRoute(), [
                'email' => 'nobody@example.com',
            ])
            ->assertRedirect($this->passwordRequestRoute())
            ->assertSessionHasErrors('email');

        Notification::assertNotSentTo(
            UserFactory::new()->make([
                'email' => 'nobody@example.com',
            ]),
            UserForgotPassword::class
        );
    }

    /** @test */
    public function user_receives_an_email_with_a_password_reset_link()
    {
        Notification::fake();

        $user = UserFactory::new()->create();

        $this
            ->from($this->passwordRequestRoute())
            ->post($this->passwordEmailRoute(), [
                'email' => $user->email,
            ])
            ->assertRedirect($this->passwordRequestRoute());

        $this->assertNotNull($token = DB::table('password_resets')->first());

        Notification::assertSentTo(
            $user,
            UserForgotPassword::class,
            fn ($notification) => Hash::check($notification->token, $token->token)
        );
    }
}
