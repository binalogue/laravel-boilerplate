<?php

namespace App\Platform\Auth\Controllers;

use App\Platform\Auth\Requests\ForceResetPasswordRequest;
use Domain\Auth\DataTransferObjects\ForceResetPasswordData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Support\Providers\RouteServiceProvider;

class ForceResetPasswordController
{
    public function showResetForm(Request $request): Response
    {
        return Inertia::render('AuthPasswordForceResetPage');
    }

    public function reset(
        ForceResetPasswordRequest $forceResetPasswordRequest
    ): RedirectResponse {
        $validated = ForceResetPasswordData::fromRequest($forceResetPasswordRequest);

        /** @var \Domain\Users\Models\User */
        $user = $forceResetPasswordRequest->user();

        $user->password = Hash::make($validated->password);
        $user->password_changed_at = Carbon::now()->toDateTimeString();
        $user->save();

        Auth::guard()->login($user);

        flash()->success(is_string($message = __('auth.flash.password_reseted')) ? $message : '');

        return Redirect::to(RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE);
    }
}
