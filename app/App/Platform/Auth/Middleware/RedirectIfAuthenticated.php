<?php

namespace App\Platform\Auth\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Support\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE);
            }
        }

        return $next($request);
    }
}
