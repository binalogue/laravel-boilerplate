<?php

namespace Support\Notifications;

trait NotifiableViaSlack
{
    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return 'slack-url';
    }
}
