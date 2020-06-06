<?php

namespace Support\Providers;

use Domain\Users\Actions\CreateUserAction;
use Domain\Users\Actions\LogCreateUserAction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Support\Pagination\LengthAwarePaginator as MyLengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('logging.log_actions_enabled')) {
            $this->registerActionsLogs();
        }

        $this->registerLengthAwarePaginator();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        setlocale(LC_TIME, config('app.country_locale').'.UTF-8');
        Carbon::setLocale(config('app.country_locale'));

        Blade::if('env', function ($environment) {
            return App::environment($environment);
        });

        Blade::if('route', function ($routeName) {
            return Route::is($routeName);
        });
    }

    protected function registerActionsLogs()
    {
        $this->app->bind(CreateUserAction::class, LogCreateUserAction::class);
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new MyLengthAwarePaginator(...array_values($values));
        });
    }
}
