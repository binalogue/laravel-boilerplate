<?php

namespace Support\Testing\Concerns;

use Support\Providers\RouteServiceProvider;

trait RegistrationRoutes
{
    protected function preRegisterRoute()
    {
        return route('preRegister.form');
    }

    protected function registerPreRoute()
    {
        return route('preRegister.form');
    }

    protected function registerGetRoute(?string $email = ''): string
    {
        return route('register.form', [
            'email' => $email,
        ]);
    }

    protected function registerPostRoute()
    {
        return route('register');
    }

    protected function successfulRegistrationRoute(): string
    {
        return RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE;
    }
}
