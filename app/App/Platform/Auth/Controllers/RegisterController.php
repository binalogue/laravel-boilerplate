<?php

namespace App\Platform\Auth\Controllers;

use Domain\Auth\DataTransferObjects\PreRegisterData;
use Domain\Users\Actions\CreateUserAction;
use Domain\Users\DataTransferObjects\UserData;
use App\Platform\Auth\Requests\PreRegisterRequest;
use App\Platform\Auth\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Support\Providers\RouteServiceProvider;

/**
 * @see \Illuminate\Foundation\Auth\RegistersUsers
 * @see \Tests\App\Platform\Auth\Controllers\RegisterControllerTest
 */
class RegisterController
{
    public function showRegisterForm(PreRegisterRequest $preRegisterRequest): Response
    {
        $preRegisterData = PreRegisterData::fromRequest($preRegisterRequest);

        return Inertia::render('AuthRegisterPage', [
            'newUser' => [
                'email' => $preRegisterData->email,
            ],
        ]);
    }

    public function register(
        RegisterRequest $registerRequest,
        CreateUserAction $createUserAction
    ): RedirectResponse {
        $user = $createUserAction->execute(
            UserData::fromRegisterRequest($registerRequest)
        );

        event(new Registered($user));

        Auth::guard()->login($user);

        return Redirect::to(RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE);
    }
}
