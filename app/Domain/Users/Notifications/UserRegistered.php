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
            ->subject(__('users.notifications.registered.mail.subject'))
            ->greeting(__('users.notifications.registered.mail.greeting', [
                'name' => $notifiable->first_name,
            ]))
            ->line(__('users.notifications.registered.mail.intro_line_1'))
            ->line(__('users.notifications.registered.mail.intro_line_2'))
            ->action(
                __('users.notifications.registered.mail.action'),
                $verificationUrl
            )
            ->salutation(__('users.notifications.registered.mail.salutation'));
    }
}
