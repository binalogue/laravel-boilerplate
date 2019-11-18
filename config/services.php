<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
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
