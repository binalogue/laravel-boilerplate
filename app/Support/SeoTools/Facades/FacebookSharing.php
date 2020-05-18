<?php

namespace Support\SeoTools\Facades;

use Illuminate\Support\Facades\Facade;

class FacebookSharing extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'seotools.facebook';
    }
}
