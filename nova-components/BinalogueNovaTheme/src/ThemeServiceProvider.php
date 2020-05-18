<?php

namespace Binalogue\BinalogueNovaTheme;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::theme(asset('/vendor/binalogue/binalogue-nova-theme/theme.css'));

        $this->publishes([
            __DIR__ . '/../resources/css' => public_path('vendor/binalogue/binalogue-nova-theme'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
