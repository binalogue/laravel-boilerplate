<?php

namespace App\Platform\Auth\Controllers;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController
{
    public function redirectToProvider(string $driver): RedirectResponse
    {
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback(string $driver)
    {
        try {
            /** @var \Laravel\Socialite\Contracts\User */
            $socialiteUser = Socialite::driver($driver)->user();
        } catch (\Exception $ex) {
            return Redirect::route('login.form');
        }

        $existingUser = User::withTrashed()
            ->where('email', $socialiteUser->email)
            ->first();

        if ($existingUser) {
            if ($existingUser->trashed()) {
                $existingUser->restore();

                flash()->success(__('status.auth.restored'));
            }

            if (is_null($existingUser->email_verified_at)) {
                $existingUser->update([
                    'email_verified_at' => now(),
                ]);
            }

            if (is_null($existingUser->{"{$driver}_id"})) {
                $existingUser->update([
                    "{$driver}_id" => $socialiteUser->getId(),
                ]);
            }

            Auth::login($existingUser, true);

            return Redirect::route('profile.show');
        }

        $validated = UserData::fromSocialiteUser($socialiteUser, $driver);

        return Inertia::render('AuthRegisterPage', [
            'newUser' => $validated->only(
                'first_name',
                'last_name',
                'email',
                "{$driver}_id",
                'avatar',
            )->toArray(),
        ]);
    }
}
