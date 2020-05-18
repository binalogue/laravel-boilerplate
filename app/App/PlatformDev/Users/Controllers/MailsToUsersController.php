<?php

namespace App\PlatformDev\Users\Controllers;

use Domain\Users\Models\User;
use Domain\Users\Notifications\UserForgotPassword;
use Domain\Users\Notifications\UserRegistered;
use Domain\Users\Notifications\UserRequestedVerification;
use Domain\Users\Notifications\UserVerified;

class MailsToUsersController
{
    protected User $notifiable;

    public function __construct()
    {
        $this->notifiable = User::find(1);
    }

    public function userRegistered()
    {
        return (new UserRegistered())->toMail($this->notifiable);
    }

    public function userRequestedVerification()
    {
        return (new UserRequestedVerification())->toMail($this->notifiable);
    }

    public function userVerified()
    {
        return (new UserVerified())->toMail($this->notifiable);
    }

    public function userForgotPassword()
    {
        return (new UserForgotPassword('invalid-token'))->toMail($this->notifiable);
    }
}
