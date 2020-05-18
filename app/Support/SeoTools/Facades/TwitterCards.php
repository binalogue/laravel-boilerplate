<?php

namespace Support\SeoTools\Facades;

use Illuminate\Support\Facades\Facade;

class TwitterCards extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'seotools.twitter';
    }
}
