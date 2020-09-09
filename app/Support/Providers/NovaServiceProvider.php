<?php

namespace Support\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Panel;
use OptimistDigital\NovaSettings\NovaSettings;
use Sbine\RouteViewer\RouteViewer;
use Timothyasp\Color\Color;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Nova::serving(function () {
            app()->setLocale('en');
        });

        Nova::userTimezone(function (Request $request) {
            return config('app.timezone');
        });

        NovaSettings::addSettingsFields([
            new Panel('App', [
                Text::make('Name', 'app_name'),
            ]),

            new Panel('Media', [
                Image::make('Logo', 'logo')
                    ->disk('public')
                    ->path('nova-settings/logo'),
            ]),

            new Panel('Styles', [
                Color::make('Primary', 'color_primary')
                    ->slider(),
                Color::make('Primary Hover', 'color_primary_hover')
                    ->slider(),
                Color::make('Black', 'color_black')
                    ->slider(),
                Color::make('Grey', 'color_grey')
                    ->slider(),
                Color::make('White', 'color_white')
                    ->slider(),
                Color::make('Alerts', 'color_alerts')
                    ->slider(),
            ]),

            new Panel('Content', [
                //
            ]),

            new Panel('Mail', [
                Text::make('From Address', 'mail_from_address'),
                Text::make('From Name', 'mail_from_name'),
                Text::make('Reply To Address', 'mail_reply_to_address'),
                Text::make('Reply To Name', 'mail_reply_to_name'),
            ]),

            new Panel('Admin', [
                Code::make('Admin Logo', 'admin_logo'),
            ]),
        ], [
            //
        ]);
    }

    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return $user->isEditor();
        });
    }

    protected function cards(): array
    {
        return [];
    }

    protected function dashboards(): array
    {
        return [];
    }

    public function tools(): array
    {
        return [
            new NovaSettings(),
            (new RouteViewer())
                ->canSee(fn ($request) => $request->user()->isSuperAdmin()),
        ];
    }

    public function register(): void
    {
        //
    }
}
