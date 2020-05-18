<?php

namespace Tests\App\Nova;

use Tests\TestCase;

class NovaTest extends TestCase
{
    /** @test */
    public function nova_is_enabled()
    {
        $response = $this->get('/nova');

        $response->assertRedirect('/nova/login');
    }
}
