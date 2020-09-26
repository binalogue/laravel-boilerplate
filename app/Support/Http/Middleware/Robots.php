<?php

namespace Support\Http\Middleware;

use Illuminate\Http\Request;
use Spatie\RobotsMiddleware\RobotsMiddleware;

class Robots extends RobotsMiddleware
{
    protected function shouldIndex(Request $request): bool
    {
        if (! config('app.allow_robots')) {
            return false;
        }

        if (! app()->environment('production')) {
            return false;
        }

        return true;
    }
}
