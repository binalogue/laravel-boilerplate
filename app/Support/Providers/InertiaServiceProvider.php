<?php

namespace Support\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
                    /** @var \Domain\Users\Models\User */
                    $user = Auth::user();

                    return [
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                        ],

                        'notifications' => $user->unreadNotificationsMessages(),
                    ];
                }

                return null;
            },

            'csrfToken' => fn () => csrf_token(),

            'errors' => fn () => Session::get('errors')
                ? Session::get('errors')->getBag('default')->getMessages()
                : (object) [],

            'flash' => fn () => [
                'message' => flash()->message,
                'level' => flash()->level,
                'class' => flash()->class,
            ],

            'meta' => fn () => MetaTags::generateVueMeta(),
        ]);
    }
}
