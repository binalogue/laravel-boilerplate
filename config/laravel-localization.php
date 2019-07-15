<?php

return [

    'routes' => [

        /*
        |--------------------------------------------------------------------------
        | Route prefix
        |--------------------------------------------------------------------------
        |
        | Example of route: http://localhost/js/localizations.js
        |
        */

        'prefix' => env('LARAVEL_LOCALIZATION_PREFIX', '/js/localization.js'),

        /*
        |--------------------------------------------------------------------------
        | Route name
        |--------------------------------------------------------------------------
        |
        | Defaults to assets.lang
        |
        */

        'name' => env('LARAVEL_LOCALIZATION_ROUTE_NAME', 'assets.lang'),

        /*
        |--------------------------------------------------------------------------
        | Middleware used on localization routes
        |--------------------------------------------------------------------------
        |
        | You can add more middleware with .env directive, example LARAVEL_LOCALIZATION_MIDDLEWARE=web,auth:api, etc.
        |
        | Don't use space in .env directive after ,
        |
        */

        'middleware' => (env('LARAVEL_LOCALIZATION_MIDDLEWARE'))
            ? explode(',', env('LARAVEL_LOCALIZATION_MIDDLEWARE'))
            : [],

        /*
        |--------------------------------------------------------------------------
        | Enable public URL
        |--------------------------------------------------------------------------
        |
        | Enable public URL from which we can access translations.
        |
        */

        'enable' => env('LARAVEL_LOCALIZATION_ROUTE_ENABLE', false),
    ],

    'events' => [

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        |
        | This package emits some events after it getters all translation messages.
        |
        | Here you can change channel on which events will broadcast.
        |
        */

        'channel' => env('LARAVEL_LOCALIZATION_EVENTS_CHANNEL', ''),
    ],

    'caches' => [

        /*
        |--------------------------------------------------------------------------
        | Cache Driver
        |--------------------------------------------------------------------------
        |
        | What cache driver do you want to use - more information: https://laravel.com/docs/5.6/cache#driver-prerequisites
        |
        */

        'driver' => config('cache.default'),

        /*
        |--------------------------------------------------------------------------
        | Key name of the cache entry for the localization array
        |--------------------------------------------------------------------------
        */

        'key' => 'localization.array',

        /*
        |--------------------------------------------------------------------------
        | Timeout of the cached data in minutes
        |--------------------------------------------------------------------------
        |
        | Set to 0 to disable.
        |
        */

        'timeout' => 60,
    ],

    'js' => [

        /*
        |--------------------------------------------------------------------------
        | Default locale for export.
        |--------------------------------------------------------------------------
        */

        'default_locale' => config('app.locale'),

        /*
        |--------------------------------------------------------------------------
        | Root location to where JavaScript file will be exported
        |--------------------------------------------------------------------------
        */

        'filepath' => resource_path('assets/js'),

        /*
        |--------------------------------------------------------------------------
        | File name for JavaScript file with exported messages
        |--------------------------------------------------------------------------
        */

        'filename' => 'll_messages.js',
    ],

    'paths'  => [

        /*
        |--------------------------------------------------------------------------
        | Export more lang files
        |-------------------------------------------------------------------------
        */

        'lang_dirs' => [resource_path('lang')],
    ],

];
