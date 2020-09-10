<?php

namespace Tests\App\Platform\Home\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see \App\Platform\Home\Controllers\HomeController */
class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_home_page()
    {
        $this
            ->get(route('home'))
            ->assertStatus(200);
    }
}
