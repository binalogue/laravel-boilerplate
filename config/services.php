<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID'),
        'admins' => env('FACEBOOK_ADMINS'),
        'page_url' => env('FACEBOOK_PAGE_URL'),
    ],

    'googleanalytics' => [
        'id' => env('GOOGLEANALYTICS_ID'),
    ],

    'twitter' => [
        'site' => env('TWITTER_SITE'),
        'creator' => env('TWITTER_CREATOR'),
    ],

];
