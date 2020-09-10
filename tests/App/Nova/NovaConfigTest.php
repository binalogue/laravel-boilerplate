<?php

namespace Tests\App\Nova;

use Tests\NovaTestCase;

class NovaConfigTest extends NovaTestCase
{
    /** @test **/
    public function nova_app_is_named_correctly()
    {
        $this->assertEquals(config('app.name'), config('nova.name'));
    }

    /** @test **/
    public function nova_app_is_at_the_correct_url()
    {
        $this->assertEquals('/admin', config('nova.path'));
    }
}
