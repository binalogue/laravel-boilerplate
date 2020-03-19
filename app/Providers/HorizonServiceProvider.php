<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSlackNotificationsTo(
        //     'https://hooks.slack.com/services/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',
        //     '#notifications-vw-wdf'
        // );

        Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user) {
            return $user->isSuperAdmin();
        });
    }
}
