<?php

namespace Domain\Users\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserForgotPassword extends ResetPassword implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notifications.user.forgot_password.mail.subject'))
            ->greeting(__('notifications.user.forgot_password.mail.greeting', [
                'name' => $notifiable->name,
            ]))
            ->line(__('notifications.user.forgot_password.mail.intro_line'))
            ->action(
                __('notifications.user.forgot_password.mail.action'),
                url(route('password.reset', [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]))
            )
            ->line(__('notifications.user.forgot_password.mail.outro_line_1', [
                'count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
            ]))
            ->line(__('notifications.user.forgot_password.mail.outro_line_2'))
            ->salutation(__('notifications.user.forgot_password.mail.salutation'));
    }
}
