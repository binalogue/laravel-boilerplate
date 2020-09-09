<?php

namespace App\Platform\Auth\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LoginController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function redirectTo(): string
    {
        return route('profile.show');
    }

    /*
    |--------------------------------------------------------------------------
    | AuthenticatesUsers
    |--------------------------------------------------------------------------
    */

    public function showLoginForm(): Response
    {
        return Inertia::render('AuthLoginPage');
    }

    protected function loggedOut(): RedirectResponse
    {
        return Redirect::route('home');
    }
}
