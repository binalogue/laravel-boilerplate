<?php

namespace App\Platform\Users\Controllers\Auth;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

/**
 * @see \Illuminate\Foundation\Auth\VerifiesEmails
 */
class VerificationController
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

    /**
     * Where to redirect users after verifying their email.
     *
     * @return string
     */
    protected function redirectTo(): string
    {
        return route('profile.show');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? Redirect::to($this->redirectTo())
            : Inertia::render('AuthVerificationPage');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (!hash_equals(
            (string) $request->route('id'),
            (string) $request->user()->getKey()
        )) {
            throw new AuthorizationException();
        }

        if (!hash_equals(
            (string) $request->route('hash'),
            sha1($request->user()->getEmailForVerification())
        )) {
            throw new AuthorizationException();
        }

        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::to($this->redirectTo());
        }

        if (!$request->user()->markEmailAsVerified()) {
            throw new AuthorizationException();
        }

        event(new Verified($request->user()));

        flash([
            'status' => __('status.auth.verified'),
        ]);

        return Redirect::to($this->redirectTo());
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::route('profile.show');
        }

        $request->user()->sendEmailVerificationNotification();

        flash([
            'status' => __('status.auth.requested_verification'),
        ]);

        return Redirect::back();
    }
}
