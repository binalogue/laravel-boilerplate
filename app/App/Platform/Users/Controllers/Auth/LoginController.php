<?php

namespace App\Platform\Users\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return route('profile.show');
    }

    /*
    |--------------------------------------------------------------------------
    | AuthenticatesUsers
    |--------------------------------------------------------------------------
    */

    /**
     * Return Inertia.js view rather than the auth login view.
     *
     * @return \Inertia\Response
     */
    public function showLoginForm()
    {
        return Inertia::render('AuthLoginPage');
    }

    /**
     * The user has logged out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function loggedOut()
    {
        return Redirect::route('home');
    }
}
