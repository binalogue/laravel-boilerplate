<?php

namespace Domain\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Support\Eloquent\User;

class UserVerifiedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(is_string($subject = __('users.notifications.verified.mail.subject')) ? $subject : '')
            ->greeting(is_string($greeting = __('users.notifications.verified.mail.greeting', [
                'name' => $notifiable->first_name,
            ])) ? $greeting : '')
            ->line(__('users.notifications.verified.mail.intro_line_1'))
            ->line(__('users.notifications.verified.mail.intro_line_2'))
            ->line(__('users.notifications.verified.mail.intro_line_3'))
            ->action(
                is_string($action = __('users.notifications.verified.mail.action')) ? $action : '',
                route('profile.show')
            )
            ->line(__('users.notifications.verified.mail.outro_line', [
                'url' => route('pages.home'),
            ]))
            ->salutation(is_string($salutation = __('users.notifications.verified.mail.salutation')) ? $salutation : '');
    }
}
