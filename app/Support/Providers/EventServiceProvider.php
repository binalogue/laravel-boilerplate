<?php

namespace Support\Providers;

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
        // @use-preset-event-service-provider-subscribe
    ];

    public function boot(): void
    {
        $this->bootModelObservers();
    }

    protected function bootModelObservers(): void
    {
        // @use-preset-event-service-provider-boot-model-observers
    }
}
