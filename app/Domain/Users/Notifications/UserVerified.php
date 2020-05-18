<?php

namespace Domain\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserVerified extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('notifications.user.verified.mail.subject'))
            ->greeting(__('notifications.user.verified.mail.greeting', [
                'name' => $notifiable->name,
            ]))
            ->line(__('notifications.user.verified.mail.intro_line_1'))
            ->line(__('notifications.user.verified.mail.intro_line_2'))
            ->line(__('notifications.user.verified.mail.intro_line_3'))
            ->action(
                __('notifications.user.verified.mail.action'),
                route('profile.show')
            )
            ->line(__('notifications.user.verified.mail.outro_line', [
                'url' => route('legal.conditions')
            ]))
            ->salutation(__('notifications.user.verified.mail.salutation'));
    }
}
