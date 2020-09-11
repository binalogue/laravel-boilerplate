<?php

namespace Tests\App\Platform\Users\Controllers;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see \App\Platform\Users\Controllers\ProfileController */
class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
    |----------------------------------------------------------------------
    | Show
    |----------------------------------------------------------------------
    */

    /** @test */
    public function user_can_see_their_profile()
    {
        $this
            ->actingAs(UserFactory::new()->verified()->create())
            ->get(route('profile.show'))
            ->assertSuccessful();
    }
}
