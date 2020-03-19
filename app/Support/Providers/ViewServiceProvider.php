<?php

namespace Support\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Support\View\AppViewComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('app', AppViewComposer::class);
    }
}
