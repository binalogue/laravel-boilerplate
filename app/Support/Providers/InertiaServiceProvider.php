<?php

namespace Support\Providers;

use Illuminate\Support\Facades\Auth;
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
                if (Auth::check()) {
                    $user = Auth::user();

                    return [
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->first_name,
                            'email' => $user->email,
                        ],

                        'notifications' => $user->unreadNotificationsMessages(),
                    ];
                }

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
