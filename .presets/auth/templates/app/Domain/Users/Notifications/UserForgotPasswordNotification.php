<?php

namespace Domain\Users\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserForgotPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(is_string($subject = __('users.notifications.forgot_password.mail.subject')) ? $subject : '')
            ->greeting(is_string($greeting = __('users.notifications.forgot_password.mail.greeting', [
                'name' => $notifiable->first_name,
            ])) ? $greeting : '')
            ->line(__('users.notifications.forgot_password.mail.intro_line'))
            ->action(
                is_string($action = __('users.notifications.forgot_password.mail.action')) ? $action : '',
                url(route('password.reset', [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]))
            )
            ->line(__('users.notifications.forgot_password.mail.outro_line_1', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
            ]))
            ->line(__('users.notifications.forgot_password.mail.outro_line_2'))
            ->salutation(is_string($salutation = __('users.notifications.forgot_password.mail.salutation')) ? $salutation : '');
    }
}
