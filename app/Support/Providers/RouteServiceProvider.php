<?php

namespace Support\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
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
        $this->bootRouteModelBinding();

        parent::boot();
    }

    protected function bootRouteModelBinding(): void
    {
        //
    }

    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        if (! App::environment('production')) {
            $this->mapDevelopmentRoutes();
        }
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    protected function mapDevelopmentRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/development.php'));
    }
}
