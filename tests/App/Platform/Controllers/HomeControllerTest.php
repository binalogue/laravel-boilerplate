<?php

namespace Tests\App\Platform\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_home_page()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }
}
