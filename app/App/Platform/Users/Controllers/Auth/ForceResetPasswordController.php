<?php

namespace App\Platform\Users\Controllers\Auth;

use App\Platform\Users\Requests\ForceResetPasswordRequest;
use Domain\Auth\DataTransferObjects\ForceResetPasswordData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ForceResetPasswordController
{
    /**
     * Return the AuthNewPasswordResetPage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function showResetForm(Request $request)
    {
        return Inertia::render('AuthPasswordForceResetPage');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \App\Platform\Users\Requests\ForceResetPasswordRequest  $forceResetPasswordRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(ForceResetPasswordRequest $forceResetPasswordRequest)
    {
        $validated = ForceResetPasswordData::fromRequest($forceResetPasswordRequest);

        /** @var \Domain\Users\Models\User */
        $user = $forceResetPasswordRequest->user();

        $user->password = Hash::make($validated->password);
        $user->password_changed_at = Carbon::now()->toDateTimeString();
        $user->save();

        Auth::guard()->login($user);

        flash([
            'status' => __('status.auth.password_reseted'),
        ]);

        return Redirect::route('profile.show');
    }
}
