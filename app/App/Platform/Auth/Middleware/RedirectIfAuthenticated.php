<?php

namespace App\Platform\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /** @return \Closure|\Illuminate\Http\RedirectResponse */
    public function handle(Request $request, Closure $next, ?string ...$guards)
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
