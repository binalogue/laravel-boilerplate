<?php

namespace App\Platform\Auth\Controllers;

use App\Platform\Auth\Requests\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @see \Illuminate\Foundation\Auth\SendsPasswordResetEmails
 * @see \Tests\App\Platform\Auth\Controllers\ForgotPasswordControllerTest
 */
class ForgotPasswordController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails.
    |
    */

    public function showLinkRequestForm(): Response
    {
        return Inertia::render('AuthPasswordRequestPage');
    }

    public function sendResetLinkEmail(
        ForgotPasswordRequest $forgotPasswordRequest
    ): RedirectResponse {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = Password::broker()->sendResetLink(
            $forgotPasswordRequest->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($forgotPasswordRequest, $response)
            : $this->sendResetLinkFailedResponse($forgotPasswordRequest, $response);
    }

    protected function sendResetLinkResponse(
        ForgotPasswordRequest $forgotPasswordRequest,
        string $response
    ): RedirectResponse {
        flash()->success(__($response));

        return Redirect::back();
    }

    protected function sendResetLinkFailedResponse(
        ForgotPasswordRequest $forgotPasswordRequest,
        string $response
    ): RedirectResponse {
        return Redirect::back()
            ->withInput($forgotPasswordRequest->only('email'))
            ->withErrors([
                'email' => __($response),
            ]);
    }
}
