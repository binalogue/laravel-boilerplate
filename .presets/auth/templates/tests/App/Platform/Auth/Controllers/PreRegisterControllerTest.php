<?php

namespace Tests\App\Platform\Auth\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\Testing\Concerns\RegistrationRoutes;
use Tests\TestCase;

/** @see \App\Platform\Auth\Controllers\PreRegisterController */
class PreRegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    use RegistrationRoutes;

    /*
    |--------------------------------------------------------------------------
    | Action: showPreRegisterForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_can_see_the_pre_register_form()
    {
        // 🙅‍♂️ No authenticated user.

        $this
            ->get($this->preRegisterRoute())
            ->assertSuccessful();
    }
}
