<?php

namespace App\PlatformDev\Mails\Controllers;

use Domain\Users\Models\User;
use Domain\Users\Notifications\UserForgotPasswordNotification;
use Domain\Users\Notifications\UserRegisteredNotification;
use Domain\Users\Notifications\UserRequestedVerificationNotification;
use Domain\Users\Notifications\UserVerifiedNotification;
use Illuminate\Notifications\Messages\MailMessage;

class MailsController
{
    protected User $notifiable;

    public function __construct()
    {
        $user = User::find(1);

        if (! is_null($user)) {
            $this->notifiable = $user;
        } else {
            throw new \Exception('User not found');
        }
    }

    public function userRegistered(): MailMessage
    {
        return (new UserRegisteredNotification())->toMail($this->notifiable);
    }

    public function userRequestedVerification(): MailMessage
    {
        return (new UserRequestedVerificationNotification())->toMail($this->notifiable);
    }

    public function userVerified(): MailMessage
    {
        return (new UserVerifiedNotification())->toMail($this->notifiable);
    }

    public function userForgotPassword(): MailMessage
    {
        return (new UserForgotPasswordNotification('invalid-token'))->toMail($this->notifiable);
    }
}
