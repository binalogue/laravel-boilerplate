<?php

namespace App\Platform\Users\Controllers\Auth;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string  $driver
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @param  string  $driver
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function handleProviderCallback(string $driver)
    {
        try {
            /** @var \Laravel\Socialite\Contracts\User */
            $socialiteUser = Socialite::driver($driver)->user();
        } catch (\Exception $ex) {
            return Redirect::route('login');
        }

        $existingUser = User::withTrashed()
            ->where('email', $socialiteUser->getEmail())
            ->first();

        if ($existingUser) {
            if ($existingUser->trashed()) {
                $existingUser->restore();

                flash([
                    'status' => __('status.auth.restored'),
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
                'name',
                'first_surname',
                'second_surname',
                'email',
                "{$driver}_id",
                'avatar',
            )->toArray(),
        ]);
    }
}
