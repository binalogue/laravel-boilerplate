<?php

namespace Support\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const ALREADY_AUTHENTICATED_MIDDLEWARE_ROUTE = 'profile';
    public const NOT_AUTHENTICATED_MIDDLEWARE_ROUTE = 'login';

    public const LOGIN_ROUTE = 'login';
    public const LOGOUT_ROUTE = 'logout';
    public const SUCCESSFUL_LOGIN_ROUTE = 'profile';
    public const SUCCESSFUL_LOGOUT_ROUTE = '/';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->bootRoutes();
        $this->bootRouteModelBinding();
    }

    /** Configure the rate limiters for the application. */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }

    protected function bootRoutes(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            if (! App::environment('production')) {
                Route::middleware('web')
                    ->group(base_path('routes/development.php'));
            }
        });
    }

    protected function bootRouteModelBinding(): void
    {
        //
    }
}
