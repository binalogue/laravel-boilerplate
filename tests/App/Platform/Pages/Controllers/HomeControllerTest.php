<?php

namespace Tests\App\Platform\Pages\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @see \App\Platform\Pages\Controllers\HomeController */
class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_home_page()
    {
        $this
            ->get(route('pages.home'))
            ->assertStatus(200);
    }
}
