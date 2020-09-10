<?php

namespace Support\Providers;

use Domain\Users\Models\User;
use Domain\Users\Observers\UserObserver;
use Domain\Users\Subscribers\UserSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        //
    ];

    protected $subscribe = [
        UserSubscriber::class,
    ];

    public function boot(): void
    {
        parent::boot();

        $this->bootModelObservers();
    }

    protected function bootModelObservers()
    {
        User::observe(UserObserver::class);
    }
}
