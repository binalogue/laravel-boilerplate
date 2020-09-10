<?php

namespace Support\Testing\Concerns;

use Illuminate\Support\Facades\Password;
use Support\Providers\RouteServiceProvider;

trait ResetPasswordRoutes
{
    protected function getValidToken($user): string
    {
        return Password::broker()->createToken($user);
    }

    protected function getInvalidToken(): string
    {
        return 'invalid-token';
    }

    protected function passwordResetGetRoute(string $token, string $email): string
    {
        return route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    protected function passwordResetPostRoute(): string
    {
        return route('password.update');
    }

    protected function successfulPasswordResetRoute()
    {
        return RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE;
    }
}
