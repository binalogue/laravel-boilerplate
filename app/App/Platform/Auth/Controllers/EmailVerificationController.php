<?php

namespace App\Platform\Auth\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Support\Providers\RouteServiceProvider;

/**
 * @see \Illuminate\Foundation\Auth\VerifiesEmails
 * @see \Tests\App\Platform\Auth\Controllers\EmailVerificationControllerTest
 */
class EmailVerificationController
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /** Where to redirect users after verifying their email. */
    protected function redirectTo(): string
    {
        return RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE;
    }

    /** @return \Illuminate\Http\RedirectResponse|\Inertia\Response */
    public function showVerificationNotice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? Redirect::to($this->redirectTo())
            : Inertia::render('AuthVerificationPage');
    }

    /** @throws \Illuminate\Auth\Access\AuthorizationException */
    public function verify(Request $request): RedirectResponse
    {
        if (! hash_equals(
            (string) $request->route('id'),
            (string) $request->user()->getKey()
        )) {
            throw new AuthorizationException();
        }

        if (! hash_equals(
            (string) $request->route('hash'),
            sha1($request->user()->getEmailForVerification())
        )) {
            throw new AuthorizationException();
        }

        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::to($this->redirectTo());
        }

        if (! $request->user()->markEmailAsVerified()) {
            throw new AuthorizationException();
        }

        event(new Verified($request->user()));

        flash()->success(is_string($message = __('auth.flash.verified')) ? $message : '');

        return Redirect::to($this->redirectTo());
    }

    public function resend(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::to($this->redirectTo());
        }

        $request->user()->sendEmailVerificationNotification();

        flash()->success(is_string($message = __('auth.flash.requested_verification')) ? $message : '');

        return Redirect::back();
    }
}
