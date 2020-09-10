<?php

namespace App\Platform\Auth\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/** @see \Tests\App\Platform\Auth\Controllers\PreRegisterControllerTest */
class PreRegisterController
{
    public function showPreRegisterForm(): Response
    {
        return Inertia::render('AuthPreRegisterPage');
    }
}
