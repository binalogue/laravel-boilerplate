<?php

namespace Domain\Users\Subscribers;

use Domain\Users\Notifications\UserRegistered;
use Domain\Users\Notifications\UserVerified;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;

class UserSubscriber
{
    public function handleUserRegistered(Registered $event)
    {
        /** @var \Domain\Users\Models\User */
        $user = $event->user;

        $user->notify(new UserRegistered());
    }

    public function handleUserVerified(Verified $event)
    {
        /** @var \Domain\Users\Models\User */
        $user = $event->user;

        $user->notify(new UserVerified());
    }

    public function handleUserLogin(Login $event)
    {
        //
    }

    public function handleUserLogout(Logout $event)
    {
        //
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $dispatcher
     * @return void
     */
    public function subscribe($dispatcher)
    {
        $dispatcher->listen(
            Registered::class,
            self::class . '@handleUserRegistered'
        );

        $dispatcher->listen(
            Verified::class,
            self::class . '@handleUserVerified'
        );

        $dispatcher->listen(
            Login::class,
            self::class . '@handleUserLogin'
        );

        $dispatcher->listen(
            Logout::class,
            self::class . '@handleUserLogout'
        );
    }
}