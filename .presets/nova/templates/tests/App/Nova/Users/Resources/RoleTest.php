<?php

namespace Tests\App\Nova\Users\Resources;

use App\Nova\Users\Resources\Role;
use Tests\NovaTestCase;

/** @see \App\Nova\Users\Resources\Role */
class RoleTest extends NovaTestCase
{
    /** @test **/
    public function it_displays_in_navigation()
    {
        $this->assertTrue(Role::$displayInNavigation);
    }

    /** @test **/
    public function it_is_not_globally_searchable()
    {
        $this->assertFalse(Role::$globallySearchable);
    }
}
