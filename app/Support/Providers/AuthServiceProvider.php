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
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        $this->app->bind(RoleContract::class, Role::class);

        Gate::define('view-any-id', fn ($user) => $user->isSuperAdmin());

        Gate::define('update-role-attribute', UserPolicy::class . '@updateRoleAttribute');
        Gate::define('update-email-attribute', UserPolicy::class . '@updateEmailAttribute');
        Gate::define('update-password-attribute', UserPolicy::class . '@updatePasswordAttribute');
        Gate::define(
            'update-has-notifications-enabled-attribute',
            UserPolicy::class . '@updateHasNotificationsEnabledAttribute'
        );
    }
}
