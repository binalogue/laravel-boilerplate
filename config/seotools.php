<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Meta Tags
    |--------------------------------------------------------------------------
    */

    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => 'Laravel Boilerplate', // set false to total remove
            'titleBefore'  => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description'  => 'We ❤️ code', // set false to total remove
            'separator'    => ' - ',
            'keywords'     => ['binalogue', 'laravel', 'boilerplate'],
            'canonical'    => null, // Set null for using Url::current(), set false to total remove
            'robots'       => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
            'norton'    => null,
        ],

        'add_notranslate_class' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenGraph
    |--------------------------------------------------------------------------
    */

    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'Laravel Boilerplate', // set false to total remove
            'description' => 'We ❤️ code', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => 'website',
            'site_name'   => 'Laravel Boilerplate',
            'images'      => [
                [
                    'url'        => '/images/og-image.jpg',
                    'secure_url' => '/images/og-image.jpg',
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
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card'        => 'summary_large_image',
            'title'       => 'Laravel Boilerplate',
            'description' => 'We ❤️ code',
            'image'       => '/images/og-image.jpg',
            'site'        => '@binalogue',
            'creator'     => '@binalogue',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON-LD
    |--------------------------------------------------------------------------
    */

    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title'       => 'Laravel Boilerplate', // set false to total remove
            'description' => 'We ❤️ code', // set false to total remove
            'url'         => null, // Set null for using Url::current(), set false to total remove
            'type'        => 'WebPage',
            'images'      => [],
        ],
    ],
];
