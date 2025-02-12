<?php

namespace Domain\Users\Subscribers;

use Domain\Users\Notifications\UserRegisteredNotification;
use Domain\Users\Notifications\UserVerifiedNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{
    public function handleUserRegistered(Registered $event): void
    {
        /** @var \Domain\Users\Models\User */
        $user = $event->user;

        $user->notify(new UserRegisteredNotification());
    }

    public function handleUserVerified(Verified $event): void
    {
        /** @var \Domain\Users\Models\User */
        $user = $event->user;

        $user->notify(new UserVerifiedNotification());
    }

    public function handleUserLogin(Login $event): void
    {
        //
    }

    public function handleUserLogout(Logout $event): void
    {
        //
    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(
            Registered::class,
            self::class.'@handleUserRegistered'
        );

        $dispatcher->listen(
            Verified::class,
            self::class.'@handleUserVerified'
        );

        $dispatcher->listen(
            Login::class,
            self::class.'@handleUserLogin'
        );

        $dispatcher->listen(
            Logout::class,
            self::class.'@handleUserLogout'
        );
    }
}
