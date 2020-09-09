<?php

namespace Domain\Users\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegistered extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(__('notifications.user.registered.mail.subject'))
            ->greeting(__('notifications.user.registered.mail.greeting', [
                'name' => $notifiable->name,
            ]))
            ->line(__('notifications.user.registered.mail.intro_line_1'))
            ->line(__('notifications.user.registered.mail.intro_line_2'))
            ->action(
                __('notifications.user.registered.mail.action'),
                $verificationUrl
            )
            ->salutation(__('notifications.user.registered.mail.salutation'));
    }
}
