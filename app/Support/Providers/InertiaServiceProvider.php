<?php

namespace Support\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Support\SeoTools\Facades\MetaTags;

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

            'meta' => fn () => MetaTags::generateVueMeta(),
        ]);
    }
}
