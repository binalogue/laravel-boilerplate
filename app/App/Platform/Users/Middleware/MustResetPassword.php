<?php

namespace App\Platform\Users\Middleware;

use Closure;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Redirect;

class MustResetPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \Domain\Users\Models\User */
        $user = $request->user();

        if ($this->mustResetPassword($user)) {
            flash([
                'status' => __('status.auth.must_reset_password'),
            ]);

            return Redirect::route('password.force_reset');
        }

        return $next($request);
    }

    private function mustResetPassword(User $user)
    {
        if ($user->facebook_id || $user->google_id) {
            return false;
        }

        return !$user->password_changed_at;
    }
}
