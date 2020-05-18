<?php

namespace App\Platform\Notifications\Controllers;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Redirect;

class NotificationsController
{
    /**
     * Mark notification as read.
     *
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return Redirect::back();
    }
}
