<?php

namespace App\Platform\Users\Controllers\Auth;

use App\Platform\Users\Requests\AuthPreRegisterRequest;
use App\Platform\Users\Requests\AuthRegisterRequest;
use Domain\Users\Actions\CreateUserAction;
use Domain\Users\DataTransferObjects\AuthPreRegisterData;
use Domain\Users\DataTransferObjects\UserData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

/**
 * @see \Illuminate\Foundation\Auth\RegistersUsers
 */
class RegisterController
{
    /**
     * Return the AuthPreRegisterPage.
     *
     * @return \Inertia\Response
     */
    public function showPreRegisterPage()
    {
        return Inertia::render('AuthPreRegisterPage');
    }

    /**
     * Return the AuthRegisterPage.
     *
     * @param  \App\Platform\Users\Requests\AuthPreRegisterRequest  $authPreRegisterRequest
     * @return \Inertia\Response
     */
    public function showRegisterPage(AuthPreRegisterRequest $authPreRegisterRequest)
    {
        $validated = AuthPreRegisterData::fromRequest($authPreRegisterRequest);

        return Inertia::render('AuthRegisterPage', [
            'newUser' => [
                'email' => $validated->email,
            ],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Platform\Users\Requests\AuthRegisterRequest  $authRegisterRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(
        AuthRegisterRequest $authRegisterRequest,
        CreateUserAction $createUserAction
    ) {
        $user = $createUserAction->execute(
            UserData::fromAuthRegisterRequest($authRegisterRequest)
        );

        event(new Registered($user));

        Auth::guard()->login($user);

        return Redirect::route('profile.show');
    }
}
