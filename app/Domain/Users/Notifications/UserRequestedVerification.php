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
            ->subject(__('users.notifications.requested_verification.mail.subject'))
            ->greeting(__('users.notifications.requested_verification.mail.greeting', [
                'name' => $notifiable->first_name,
            ]))
            ->line(__('users.notifications.requested_verification.mail.intro_line'))
            ->action(
                __('users.notifications.requested_verification.mail.action'),
                $verificationUrl
            )
            ->salutation(__('users.notifications.requested_verification.mail.salutation'));
    }
}
