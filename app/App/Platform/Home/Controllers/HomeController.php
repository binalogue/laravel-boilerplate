<?php

namespace App\Platform\Home\Controllers;

use Inertia\Inertia;

class HomeController
{
    /**
     * Home.
     *
     * @return \Inertia\Response
     */
    public function __invoke()
    {
        return Inertia::render('HomePage');
    }
}
