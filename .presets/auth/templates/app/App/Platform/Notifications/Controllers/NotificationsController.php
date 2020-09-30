<?php

namespace App\Platform\Notifications\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Redirect;

class NotificationsController
{
    /** Mark notification as read. */
    public function __invoke(DatabaseNotification $notification): RedirectResponse
    {
        $notification->markAsRead();

        return Redirect::back();
    }
}
