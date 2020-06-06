<?php

namespace Support\Notifications;

use Illuminate\Notifications\Notifiable as BaseNotifiable;
use Illuminate\Support\Str;

trait Notifiable
{
    use BaseNotifiable;

    /**
     * Get the messages entity's unread notifications, formatted to localized messages.
     *
     * @return array
     */
    public function unreadNotificationsMessages()
    {
        return $this
            ->unreadNotifications
            ->transform(function ($notification) {
                if (Str::contains(
                    $notification->type,
                    'CustomNotification'
                )) {
                    $message = __('notifications.custom.message');
                }

                if (! $message) {
                    $message = null;
                }

                $notification->message = $message;
                $notification->created_at_formatted =
                    $notification->created_at->formatLocalized('%d %B, %Y - %H:%M');

                return $notification;
            })
            ->reject(fn ($notification) => is_null($notification->message))
            ->toArray();
    }
}
