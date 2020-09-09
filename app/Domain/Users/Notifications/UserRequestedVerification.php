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
            ->subject(__('notifications.user.requested_verification.mail.subject'))
            ->greeting(__('notifications.user.requested_verification.mail.greeting', [
                'name' => $notifiable->name,
            ]))
            ->line(__('notifications.user.requested_verification.mail.intro_line'))
            ->action(
                __('notifications.user.requested_verification.mail.action'),
                $verificationUrl
            )
            ->salutation(__('notifications.user.requested_verification.mail.salutation'));
    }
}
