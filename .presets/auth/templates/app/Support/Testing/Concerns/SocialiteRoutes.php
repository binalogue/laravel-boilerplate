<?php

namespace Support\Testing\Concerns;

trait SocialiteRoutes
{
    protected function socialiteRedirectRoute(string $driver = 'google'): string
    {
        return route('oauth', $driver);
    }

    protected function socialiteCallbackRoute(string $driver = 'google'): string
    {
        return route('oauth.callback', $driver);
    }
}
