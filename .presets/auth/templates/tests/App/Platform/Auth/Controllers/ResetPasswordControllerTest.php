<?php

namespace Tests\App\Platform\Auth\Controllers;

use Domain\Users\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Support\Testing\Concerns\ResetPasswordRoutes;
use Tests\TestCase;

/** @see \App\Platform\Auth\Controllers\ResetPasswordController */
class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;
    use ResetPasswordRoutes;

    /*
    |--------------------------------------------------------------------------
    | Action: showResetForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_can_see_the_password_reset_form()
    {
        $user = User::factory()->create();

        // 🙅‍♂️ No authenticated user.

        $this
            ->get($this->passwordResetGetRoute($token = $this->getValidToken($user), $user->email))
            ->assertSuccessful()
            ->assertPropValue('email', $user->email)
            ->assertPropValue('token', $token);
    }

    /** @test */
    public function auth_user_can_see_the_password_reset_form()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get($this->passwordResetGetRoute($token = $this->getValidToken($user), $user->email))
            ->assertSuccessful()
            ->assertPropValue('email', $user->email)
            ->assertPropValue('token', $token);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: reset
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function user_cannot_reset_password_with_invalid_token()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this
            ->from($this->passwordResetGetRoute($this->getInvalidToken(), $user->email))
            ->post($this->passwordResetPostRoute(), [
                'token' => $this->getInvalidToken(),
                'email' => $user->email,
                'password' => 'new-awesome-password',
                'password_confirmation' => 'new-awesome-password',
            ])
            ->assertRedirect($this->passwordResetGetRoute($this->getInvalidToken(), $user->email));

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('old-password', $user->fresh()->password));
        $this->assertGuest();
    }

    /** @test */
    public function user_can_reset_password_with_valid_token()
    {
        Event::fake();

        $user = User::factory()->create();

        $this
            ->post($this->passwordResetPostRoute(), [
                'token' => $this->getValidToken($user),
                'email' => $user->email,
                'password' => 'new-awesome-password',
                'password_confirmation' => 'new-awesome-password',
            ])
            ->assertRedirect($this->successfulPasswordResetRoute());

        $this->assertEquals($user->email, $user->fresh()->email);
        $this->assertTrue(Hash::check('new-awesome-password', $user->fresh()->password));
        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(PasswordReset::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }
}
