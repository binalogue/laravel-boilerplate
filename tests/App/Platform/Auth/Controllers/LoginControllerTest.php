<?php

namespace Tests\App\Platform\Auth\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Support\Providers\RouteServiceProvider;
use Tests\Factories\UserFactory;
use Tests\TestCase;

/** @see \App\Platform\Auth\Controllers\LoginController */
class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function getTooManyLoginAttemptsMessage(): string
    {
        return sprintf('/^%s$/', str_replace('\:seconds', '\d+', preg_quote(__('auth.throttle'), '/')));
    }

    /*
    |--------------------------------------------------------------------------
    | Action: showLoginForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_can_see_the_login_form()
    {
        // 🙅‍♂️ No authenticated user.

        $this
            ->get(RouteServiceProvider::LOGIN_ROUTE)
            ->assertSuccessful();
    }

    /*
    |--------------------------------------------------------------------------
    | Action: login
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_cannot_login_with_incorrect_password()
    {
        $user = UserFactory::new()->create([
            'password' => Hash::make('secret'),
        ]);

        // 🙅‍♂️ No authenticated user.

        $this
            // To make sure user is redirected back to the login page.
            ->from(RouteServiceProvider::LOGIN_ROUTE)
            ->post(RouteServiceProvider::LOGIN_ROUTE, [
                'email' => $user->email,
                'password' => 'invalid-password',
            ])
            ->assertRedirect(RouteServiceProvider::LOGIN_ROUTE)
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function guest_cannot_login_with_email_that_doesnt_exist()
    {
        // 🙅‍♂️ No authenticated user.

        $this
            ->from(RouteServiceProvider::LOGIN_ROUTE)
            ->post(RouteServiceProvider::LOGIN_ROUTE, [
                'email' => 'nobody@example.com',
                'password' => 'invalid-password',
            ])
            ->assertRedirect(RouteServiceProvider::LOGIN_ROUTE)
            ->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function guest_cannot_make_more_than_five_attempts_in_one_minute()
    {
        $user = UserFactory::new()->create([
            'password' => Hash::make($password = 'secret'),
        ]);

        // 🙅‍♂️ No authenticated user.

        foreach (range(0, 5) as $_) {
            $response = $this
                ->from(RouteServiceProvider::LOGIN_ROUTE)
                ->post(RouteServiceProvider::LOGIN_ROUTE, [
                    'email' => $user->email,
                    'password' => 'invalid-password',
                ]);
        }

        $response
            ->assertRedirect(RouteServiceProvider::LOGIN_ROUTE)
            ->assertSessionHasErrors('email');

        $this->assertRegExp(
            $this->getTooManyLoginAttemptsMessage(),
            collect(
                $response
                    ->baseResponse
                    ->getSession()
                    ->get('errors')
                    ->getBag('default')
                    ->get('email')
            )->first()
        );
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function guest_can_login_with_correct_credentials()
    {
        $user = UserFactory::new()->create([
            'password' => Hash::make($password = 'secret'),
        ]);

        // 🙅‍♂️ No authenticated user.

        $this
            ->post(RouteServiceProvider::LOGIN_ROUTE, [
                'email' => $user->email,
                'password' => $password,
            ])
            ->assertRedirect(RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function guest_can_login_with_remember_me_functionality()
    {
        $user = UserFactory::new()->create([
            'id' => random_int(1, 100),
            'password' => Hash::make($password = 'secret'),
        ]);

        // 🙅‍♂️ No authenticated user.

        $response = $this
            ->post(RouteServiceProvider::LOGIN_ROUTE, [
                'email' => $user->email,
                'password' => $password,
                'remember' => 'on',
            ])
            ->assertRedirect(RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE);

        $user = $user->fresh();

        $response->assertCookie(
            Auth::guard()->getRecallerName(),
            vsprintf('%s|%s|%s', [
                $user->id,
                $user->getRememberToken(),
                $user->password,
            ])
        );

        $this->assertAuthenticatedAs($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: logout
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function auth_user_can_logout()
    {
        $this
            ->actingAs(UserFactory::new()->create())
            ->post(RouteServiceProvider::LOGOUT_ROUTE)
            ->assertRedirect(RouteServiceProvider::SUCCESSFUL_LOGOUT_ROUTE);

        $this->assertGuest();
    }
}
