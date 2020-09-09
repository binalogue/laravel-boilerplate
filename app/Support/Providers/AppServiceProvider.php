<?php

namespace Support\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Support\Pagination\LengthAwarePaginator as MyLengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerLengthAwarePaginator();
    }

    public function boot(): void
    {
        setlocale(LC_TIME, config('app.country_locale') . '.UTF-8');
        Carbon::setLocale(config('app.country_locale'));

        Blade::if('env', function ($environment) {
            return App::environment($environment);
        });

        Blade::if('route', function ($routeName) {
            return Route::is($routeName);
        });
    }

    protected function registerLengthAwarePaginator(): void
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new MyLengthAwarePaginator(...array_values($values));
        });
    }
}
