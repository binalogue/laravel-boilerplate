<?php

namespace App\PlatformDev\Mails\Controllers;

use Domain\Users\Models\User;
use Domain\Users\Notifications\UserForgotPassword;
use Domain\Users\Notifications\UserRegistered;
use Domain\Users\Notifications\UserRequestedVerification;
use Domain\Users\Notifications\UserVerified;
use Illuminate\Notifications\Messages\MailMessage;

class MailsController
{
    protected User $notifiable;

    public function __construct()
    {
        $this->notifiable = User::find(1);
    }

    public function userRegistered(): MailMessage
    {
        return (new UserRegistered())->toMail($this->notifiable);
    }

    public function userRequestedVerification(): MailMessage
    {
        return (new UserRequestedVerification())->toMail($this->notifiable);
    }

    public function userVerified(): MailMessage
    {
        return (new UserVerified())->toMail($this->notifiable);
    }

    public function userForgotPassword(): MailMessage
    {
        return (new UserForgotPassword('invalid-token'))->toMail($this->notifiable);
    }
}
