<?php

namespace App\Platform\Home\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HomeController
{
    public function __invoke(): Response
    {
        return Inertia::render('HomePage');
    }
}
