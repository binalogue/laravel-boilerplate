<?php

namespace Tests\App\Platform\Users\Controllers;

use Domain\Users\Models\User;
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
            ->actingAs(User::factory()->verified()->create())
            ->get(route('profile.show'))
            ->assertSuccessful();
    }
}
