<?php

namespace Support\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // @use-preset-auth-service-provider-policies
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // @use-preset-auth-service-provider-boot
    }
}
