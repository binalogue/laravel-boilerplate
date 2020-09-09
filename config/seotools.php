<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Meta Tags
    |--------------------------------------------------------------------------
    */

    'meta' => [

        // If the value is "false", nothing is displayed.
        'defaults' => [
            'title' => 'Laravel Boilerplate',
            'title_before' => false, // Put defaults.title before page title, like "Laravel Boilerplate - Home".
            'separator' => ' - ',
            'description' => 'We ❤️ code',
            'keywords' => ['binalogue', 'laravel', 'boilerplate'],
            'canonical' => null, // Set "null" for using Url::current(), set "false" to total remove.
            'robots' => false, // Set to "all", "none" or any combination of "index/noindex" and "follow/nofollow".
        ],

        // If the value is "null", nothing is displayed.
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
        ],

        'add_notranslate_class' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenGraph
    |--------------------------------------------------------------------------
    */

    'opengraph' => [

        // If the value is "false", nothing is displayed.
        'defaults' => [
            'title' => 'Laravel Boilerplate',
            'description' => 'We ❤️ code',
            'url' => null, // Set "null" for using Url::current(), set "false" to total remove.
            'type' => 'website',
            'site_name' => 'Laravel Boilerplate',
            'images' => [
                [
                    'url' => '/images/og-image.jpg',
                    'secure_url' => '/images/og-image.jpg',
                    'type' => 'image/jpeg',
                    'width' => '1200',
                    'height' => '630',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Cards
    |--------------------------------------------------------------------------
    */

    'twitter' => [

        // If the value is "false", nothing is displayed.
        'defaults' => [
            'card' => 'summary_large_image',
            'title' => 'Laravel Boilerplate',
            'description' => 'We ❤️ code',
            'image' => '/images/og-image.jpg',
            'site' => '@binalogue',
            'creator' => '@binalogue',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Facebook Sharing
    |--------------------------------------------------------------------------
    */

    'facebook' => [

        'app_id' => env('FACEBOOK_APP_ID'),
    ],
];
