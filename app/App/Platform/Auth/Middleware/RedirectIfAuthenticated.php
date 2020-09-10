<?php

namespace App\Platform\Auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Support\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return Redirect::to(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
        }

        return $next($request);
    }
}
