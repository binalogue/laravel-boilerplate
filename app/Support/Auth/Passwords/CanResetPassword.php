<?php

namespace Support\Auth\Passwords;

use Domain\Users\Notifications\UserForgotPassword;
use Illuminate\Auth\Passwords\CanResetPassword as BaseCanResetPassword;

trait CanResetPassword
{
    use BaseCanResetPassword;

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserForgotPassword($token));
    }
}
