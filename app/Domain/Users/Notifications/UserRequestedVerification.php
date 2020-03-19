<?php

namespace Domain\Users\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRequestedVerification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
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
