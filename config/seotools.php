<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Meta Tags
    |--------------------------------------------------------------------------
    */

    'meta' => [

        // The default configurations to be used by the MetaTags generator.
        // If the value is 'false', nothing is displayed.
        'defaults' => [
            'title'       => 'Laravel Boilerplate',
            // Put defaults.title before page title, like "Laravel App - Dashboard".
            'titleBefore' => false,
            'separator'   => ' - ',
            'description' => 'We ❤️ code',
            'keywords'    => [],
            // Set 'null' for using Url::current(), set 'false' to total remove.
            'canonical'   => null,
            // Set to 'all', 'none' or any combination of 'index/noindex' and 'follow/nofollow'.
            'robots'      => false,
        ],

        // Are the settings of tags values for major webmaster tools.
        // If the value is 'null' nothing is displayed.
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],

        'add_notranslate_class' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenGraph
    |--------------------------------------------------------------------------
    */

    'opengraph' => [

        // The default configurations to be used by the OpenGraph generator.
        // If the value is 'false', nothing is displayed.
        'defaults' => [
            'title'       => 'Laravel Boilerplate',
            'description' => 'We ❤️ code',
            // Set null for using Url::current(), set false to total remove
            'url'         => null,
            'type'        => 'website',
            'site_name'   => 'Laravel Boilerplate',
            'images'      => [
                [
                    'url'        => '/images/binalogue-og.jpg',
                    'secure_url' => '/images/binalogue-og.jpg',
                    'type'       => 'image/jpeg',
                    'width'      => '1200',
                    'height'     => '630',
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

        // The default configurations to be used by the TwitterCards generator.
        // If the value is 'false', nothing is displayed.
        'defaults' => [
            'card'        => 'summary_large_image',
            'title'       => 'Laravel Boilerplate',
            'description' => 'We ❤️ code',
            'image'       => '/images/binalogue-og.jpg',
            'site'        => '@binalogue',
            'creator'     => '@binalogue',
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
