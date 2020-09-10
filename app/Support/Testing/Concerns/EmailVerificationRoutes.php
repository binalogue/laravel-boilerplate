<?php

namespace Support\Testing\Concerns;

use Illuminate\Support\Facades\URL;
use Support\Providers\RouteServiceProvider;

trait EmailVerificationRoutes
{
    protected $verificationVerifyRouteName = 'verification.verify';

    protected function verificationNoticeRoute()
    {
        return route('verification.notice');
    }

    protected function validVerificationVerifyRoute($user)
    {
        return URL::signedRoute($this->verificationVerifyRouteName, [
            'id' => $user->id,
            'hash' => sha1($user->getEmailForVerification()),
        ]);
    }

    protected function invalidVerificationVerifyRoute($user)
    {
        return route($this->verificationVerifyRouteName, [
            'id' => $user->id,
            'hash' => 'invalid-hash',
        ]);
    }

    protected function verificationResendRoute()
    {
        return route('verification.resend');
    }

    protected function successfulVerificationRoute()
    {
        return RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE;
    }
}
