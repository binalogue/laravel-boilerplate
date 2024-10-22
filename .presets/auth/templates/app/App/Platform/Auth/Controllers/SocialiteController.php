<?php

namespace App\Platform\Auth\Controllers;

use Domain\Users\DataTransferObjects\UserData;
use Domain\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use Support\Providers\RouteServiceProvider;

/** @see \Tests\App\Platform\Auth\Controllers\SocialiteControllerTest */
class SocialiteController
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function handleProviderCallback(string $driver)
    {
        try {
            /** @var \Laravel\Socialite\Contracts\User */
            $socialiteUser = Socialite::driver($driver)->user();
        } catch (\Exception $ex) {
            return Redirect::to(RouteServiceProvider::LOGIN_ROUTE);
        }

        /** @var \Domain\Users\Models\User|null */
        $existingUser = User::withTrashed()
            ->where('email', $socialiteUser->getEmail())
            ->first();

        if ($existingUser instanceof User) {
            if ($existingUser->trashed()) {
                $existingUser->restore();

                flash()->success(is_string($flash = __('auth.flash.restored')) ? $flash : '');
            }

            if (is_null($existingUser->{"{$driver}_id"})) {
                $existingUser->update([
                    "{$driver}_id" => $socialiteUser->getId(),
                ]);
            }

            Auth::login($existingUser, true);

            return Redirect::to(RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE);
        }

        $userData = UserData::fromSocialiteUser($socialiteUser, $driver);

        return Inertia::render('AuthRegisterPage', [
            'newUser' => $userData->only(
                'first_name',
                'last_name',
                'email',
                "{$driver}_id",
                'avatar',
            )->toArray(),
        ]);
    }
}
