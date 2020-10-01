<?php

namespace Support\Auth\Passwords;

use Domain\Users\Notifications\UserForgotPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword as BaseCanResetPassword;

trait CanResetPassword
{
    use BaseCanResetPassword;

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserForgotPasswordNotification($token));
    }
}
