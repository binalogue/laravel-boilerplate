<?php

namespace Support\SeoTools\Facades;

use Illuminate\Support\Facades\Facade;

class MetaTags extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'seotools.metatags';
    }
}
