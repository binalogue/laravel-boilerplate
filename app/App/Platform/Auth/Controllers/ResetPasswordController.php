<?php

namespace App\Platform\Auth\Controllers;

use App\Platform\Auth\Requests\ResetPasswordRequest;
use App\Platform\Auth\Requests\ShowResetFormRequest;
use DateTime;
use Domain\Users\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Support\Providers\RouteServiceProvider;

/**
 * @see \Illuminate\Foundation\Auth\ResetsPasswords
 * @see \Tests\App\Platform\Auth\Controllers\ResetPasswordControllerTest
 */
class ResetPasswordController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests.
    |
    */

    protected function redirectTo(): string
    {
        return RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE;
    }

    public function showResetForm(ShowResetFormRequest $showResetFormRequest, ?string $token = null): Response
    {
        return Inertia::render('AuthPasswordResetPage', [
            'email' => $showResetFormRequest->input('email'),
            'token' => $token,
        ]);
    }

    public function reset(ResetPasswordRequest $resetPasswordRequest): RedirectResponse
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = Password::broker()->reset(
            $resetPasswordRequest->only([
                'email',
                'token',
                'password',
                'password_confirmation',
            ]),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response === Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($resetPasswordRequest, $response);
    }

    protected function resetPassword(User $user, string $password): void
    {
        $user->password = Hash::make($password);
        $user->password_changed_at = new DateTime();
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));

        Auth::guard()->login($user);
    }

    protected function sendResetResponse(string $response): RedirectResponse
    {
        flash()->success(is_string($flash = __($response)) ? $flash : '');

        return Redirect::to($this->redirectTo());
    }

    protected function sendResetFailedResponse(
        ResetPasswordRequest $resetPasswordRequest,
        string $response
    ): RedirectResponse {
        flash()->error(is_string($message = __($response)) ? $message : '');

        return Redirect::back()
            ->withInput($resetPasswordRequest->only('email'))
            ->withErrors([
                'email' => $message,
            ]);
    }
}
