<?php

namespace App\Platform\Auth\Middleware;

use Closure;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Redirect;

class MustResetPassword
{
    public function handle($request, Closure $next)
    {
        /** @var \Domain\Users\Models\User */
        $user = $request->user();

        if ($this->mustResetPassword($user)) {
            flash()->warning(__('status.auth.must_reset_password'));

            return Redirect::route('password.forceReset');
        }

        return $next($request);
    }

    protected function mustResetPassword(User $user)
    {
        if ($user->google_id) {
            return false;
        }

        return !$user->password_changed_at;
    }
}
