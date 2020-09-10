<?php

namespace Support\Testing\Concerns;

trait ForgotPasswordRoutes
{
    protected function passwordRequestRoute(): string
    {
        return route('password.request');
    }

    protected function passwordEmailRoute(): string
    {
        return route('password.email');
    }
}
