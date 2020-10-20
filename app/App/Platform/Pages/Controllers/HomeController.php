<?php

namespace App\Platform\Pages\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/** @see \Tests\App\Platform\Pages\Controllers\HomeControllerTest */
class HomeController
{
    public function __invoke(): Response
    {
        return Inertia::render('HomePage');
    }
}
