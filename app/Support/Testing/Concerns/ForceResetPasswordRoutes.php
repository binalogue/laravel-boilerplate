<?php

namespace Support\Testing\Concerns;

trait ForceResetPasswordRoutes
{
    protected function forceResetPasswordRoute(): string
    {
        return route('password.forceReset');
    }

    protected function forceResetPasswordUpdateRoute(): string
    {
        return route('password.forceResetUpdate');
    }
}
