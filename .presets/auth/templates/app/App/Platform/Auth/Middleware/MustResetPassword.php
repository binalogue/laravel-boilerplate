<?php

namespace App\Platform\Auth\Middleware;

use Closure;
use Domain\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MustResetPassword
{
    /** @return \Closure|\Illuminate\Http\RedirectResponse */
    public function handle(Request $request, Closure $next)
    {
        /** @var \Domain\Users\Models\User */
        $user = $request->user();

        if ($this->mustResetPassword($user)) {
            flash()->warning(is_string($flash = __('auth.flash.must_reset_password')) ? $flash : '');

            return Redirect::route('password.forceReset');
        }

        return $next($request);
    }

    protected function mustResetPassword(User $user): bool
    {
        if (! is_null($user->google_id)) {
            return false;
        }

        return ! $user->password_changed_at;
    }
}
