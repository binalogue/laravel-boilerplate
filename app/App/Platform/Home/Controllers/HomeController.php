<?php

namespace App\Platform\Home\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/** @see \Tests\App\Platform\Home\Controllers\HomeControllerTest */
class HomeController
{
    public function __invoke(): Response
    {
        return Inertia::render('HomePage');
    }
}
