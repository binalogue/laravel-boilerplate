<?php

namespace Support\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Support\SeoTools\Facades\MetaTags;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });

        Inertia::share([
            'auth' => fn () => Auth::check()
                ? [
                    'user' => [
                        'id' => Auth::user()->id,
                        'name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ],

                    'notifications' => Auth::user()->unreadNotificationsMessages(),
                ]
                : null,

            'csrfToken' => function () {
                return csrf_token();
            },

            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },

            'flash' => function () {
                return [
                    'status' => Session::get('status'),
                    'isError' => Session::get('isError'),
                ];
            },

            'meta' => function () {
                return MetaTags::generateVueMeta();
            },
        ]);
    }
}
