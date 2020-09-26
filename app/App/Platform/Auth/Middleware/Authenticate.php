<?php

namespace App\Platform\Auth\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        return route('login.form');
    }
}
