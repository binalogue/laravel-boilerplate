<?php

namespace Support\Providers;

use Domain\Users\Models\User;
use Domain\Users\Observers\UserObserver;
use Domain\Users\Subscribers\UserSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

    /**
     * The event subscriber mappings for the application.
     *
     * @var array
     */
    protected $subscribe = [
        UserSubscriber::class,
    ];

    public function boot(): void
    {
        $this->bootModelObservers();
    }

    protected function bootModelObservers(): void
    {
        User::observe(UserObserver::class);
    }
}
