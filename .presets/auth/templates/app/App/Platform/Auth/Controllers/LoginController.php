<?php

namespace App\Platform\Auth\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Support\Providers\RouteServiceProvider;

/**
 * @see \Illuminate\Foundation\Auth\AuthenticatesUsers
 * @see \Tests\App\Platform\Auth\Controllers\LoginControllerTest
 */
class LoginController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to the correct route.
    |
    */

    use AuthenticatesUsers;

    protected function redirectTo(): string
    {
        return RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE;
    }

    /*
    |--------------------------------------------------------------------------
    | use AuthenticatesUsers
    |--------------------------------------------------------------------------
    */

    public function showLoginForm(): Response
    {
        return Inertia::render('AuthLoginPage');
    }

    protected function loggedOut(): RedirectResponse
    {
        return Redirect::to(RouteServiceProvider::SUCCESSFUL_LOGOUT_ROUTE);
    }
}
