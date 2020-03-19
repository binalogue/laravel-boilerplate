<?php

namespace Support\Providers;

use Domain\Users\Contracts\Role as RoleContract;
use Domain\Users\Models\Role;
use Domain\Users\Models\User;
use Domain\Users\Policies\RolePolicy;
use Domain\Users\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app->bind(RoleContract::class, Role::class);

        Gate::define('view-any-id', fn ($user) => $user->isSuperAdmin());

        Gate::define('update-email', UserPolicy::class . '@updateEmail');
        Gate::define('update-password', UserPolicy::class . '@updatePassword');
    }
}
