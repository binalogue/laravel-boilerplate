<?php

namespace Domain\Users\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRequestedVerification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(is_string($subject = __('users.notifications.requested_verification.mail.subject')) ? $subject : '')
            ->greeting(is_string($greeting = __('users.notifications.requested_verification.mail.greeting', [
                'name' => $notifiable->first_name,
            ])) ? $greeting : '')
            ->line(__('users.notifications.requested_verification.mail.intro_line'))
            ->action(
                is_string($action = __('users.notifications.requested_verification.mail.action')) ? $action : '',
                $verificationUrl
            )
            ->salutation(is_string($salutation = __('users.notifications.requested_verification.mail.salutation')) ? $salutation : '');
    }
}
