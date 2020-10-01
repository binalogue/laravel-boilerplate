<?php

namespace Support\SeoTools;

use Artesaos\SEOTools\Facades\SEOMeta;

class SeoTools
{
    public static function generateVueMeta(): array
    {
        $title = SEOMeta::getTitle();

        return [
            'title' => $title,
        ];
    }
}
