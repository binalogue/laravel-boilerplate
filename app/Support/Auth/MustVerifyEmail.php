<?php

namespace Support\Auth;

use Domain\Users\Notifications\UserRequestedVerification;
use Illuminate\Auth\MustVerifyEmail as BaseMustVerifyEmail;

trait MustVerifyEmail
{
    use BaseMustVerifyEmail;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserRequestedVerification());
    }
}
