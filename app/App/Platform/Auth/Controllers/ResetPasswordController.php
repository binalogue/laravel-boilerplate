<?php

namespace App\Platform\Auth\Controllers;

use DateTime;
use Domain\Users\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

/** @see \Illuminate\Foundation\Auth\ResetsPasswords */
class ResetPasswordController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    protected function redirectTo(): string
    {
        return route('profile.show');
    }

    public function showResetForm(Request $request, ?string $token = null): Response
    {
        return Inertia::render('AuthPasswordResetPage', [
            'email' => $request->email,
            'token' => $token,
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = Password::broker()->reset(
            $request->only([
                'email',
                'password',
                'password_confirmation',
                'token',
            ]),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    protected function resetPassword(User $user, string $password): void
    {
        $user->password = Hash::make($password);
        $user->password_changed_at = new DateTime();
        $user->setRememberToken(Str::random(60));
        $user->save();

        Auth::guard()->login($user);
    }

    protected function sendResetResponse(Request $request, string $response): RedirectResponse
    {
        flash()->success(__($response));

        return Redirect::to($this->redirectTo());
    }

    protected function sendResetFailedResponse(Request $request, string $response): RedirectResponse
    {
        return Redirect::back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => __($response),
            ]);
    }
}
