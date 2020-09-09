<?php

namespace App\Platform\Auth\Controllers;

use App\Platform\Auth\Requests\AuthPreRegisterRequest;
use App\Platform\Auth\Requests\AuthRegisterRequest;
use Domain\Users\Actions\CreateUserAction;
use Domain\Users\DataTransferObjects\AuthPreRegisterData;
use Domain\Users\DataTransferObjects\UserData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @see \Illuminate\Foundation\Auth\RegistersUsers
 * @see \Tests\App\Platform\Auth\Controllers\RegisterControllerTest
 */
class RegisterController
{
    public function showRegisterForm(AuthPreRegisterRequest $authPreRegisterRequest): Response
    {
        $validated = AuthPreRegisterData::fromRequest($authPreRegisterRequest);

        return Inertia::render('AuthRegisterPage', [
            'newUser' => [
                'email' => $validated->email,
            ],
        ]);
    }

    public function register(
        AuthRegisterRequest $authRegisterRequest,
        CreateUserAction $createUserAction
    ): RedirectResponse {
        $user = $createUserAction->execute(
            UserData::fromAuthRegisterRequest($authRegisterRequest)
        );

        event(new Registered($user));

        Auth::guard()->login($user);

        return Redirect::route('profile.show');
    }
}
