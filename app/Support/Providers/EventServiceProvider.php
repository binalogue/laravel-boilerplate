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
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->bootModelObservers();
    }

    protected function bootModelObservers()
    {
        User::observe(UserObserver::class);
    }
}
