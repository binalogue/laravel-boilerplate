<?php

namespace Support\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Support\SeoTools\SeoTools;

class InertiaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share([
            'auth' => function () {
                // @use-preset-inertia-service-provider-auth

                return null;
            },

            'csrfToken' => fn () => csrf_token(),

            'flash' => fn () => [
                'message' => flash()->message,
                'level' => flash()->level,
                'class' => flash()->class,
            ],

            'meta' => fn () => SeoTools::generateVueMeta(),

            'request' => function () {
                $route = Request::route();

                return [
                    'path' => Request::getPathInfo(),
                    'params' => Request::all(),
                    'full_path' => Request::fullUrl(),
                    'route_name' => $route instanceof Route
                        ? $route->getName()
                        : '',
                ];
            },
        ]);
    }
}
