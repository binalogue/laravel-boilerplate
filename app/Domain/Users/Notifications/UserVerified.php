<?php

namespace Domain\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Support\Eloquent\User;

class UserVerified extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('users.notifications.verified.mail.subject'))
            ->greeting(__('users.notifications.verified.mail.greeting', [
                'name' => $notifiable->first_name,
            ]))
            ->line(__('users.notifications.verified.mail.intro_line_1'))
            ->line(__('users.notifications.verified.mail.intro_line_2'))
            ->line(__('users.notifications.verified.mail.intro_line_3'))
            ->action(
                __('users.notifications.verified.mail.action'),
                route('profile.show')
            )
            ->line(__('users.notifications.verified.mail.outro_line', [
                'url' => route('home'),
            ]))
            ->salutation(__('users.notifications.verified.mail.salutation'));
    }
}
