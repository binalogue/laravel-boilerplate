<?php

use App\Platform\Auth\Controllers\EmailVerificationController;
use App\Platform\Auth\Controllers\ForceResetPasswordController;
use App\Platform\Auth\Controllers\ForgotPasswordController;
use App\Platform\Auth\Controllers\LoginController;
use App\Platform\Auth\Controllers\PreRegisterController;
use App\Platform\Auth\Controllers\RegisterController;
use App\Platform\Auth\Controllers\ResetPasswordController;
use App\Platform\Auth\Controllers\SocialiteController;
use App\Platform\Home\Controllers\HomeController;
use App\Platform\Notifications\Controllers\NotificationsController;
use App\Platform\Users\Controllers\ProfileController;
use App\Platform\Users\Controllers\UpdateProfileAvatarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)
    ->name('home');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

// Authentication

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login.form')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

// Pre Registration

Route::get('register', [PreRegisterController::class, 'showPreRegisterForm'])
    ->name('preRegister.form')
    ->middleware('guest');

// Registration

Route::get('register/email', [RegisterController::class, 'showRegisterForm'])
    ->name('register.form')
    ->middleware('guest');

Route::post('register', [RegisterController::class, 'register'])
    ->name('register')
    ->middleware('guest');

// Email Verification

Route::get('email/verify', [EmailVerificationController::class, 'showVerificationNotice'])
    ->name('verification.notice')
    ->middleware('auth');

Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->name('verification.verify')
    ->middleware('auth', 'signed', 'throttle:6,1');

Route::post('email/resend', [EmailVerificationController::class, 'resend'])
    ->name('verification.resend')
    ->middleware('auth', 'throttle:6,1');

// Socialite

Route::get('oauth/{driver}', [SocialiteController::class, 'redirectToProvider'])
    ->where('driver', implode('|', config('socialite.drivers')))
    ->name('oauth')
    ->middleware('guest');

Route::get('oauth/{driver}/callback', [SocialiteController::class, 'handleProviderCallback'])
    ->where('driver', implode('|', config('socialite.drivers')))
    ->name('oauth.callback');

// Password Reset

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('password/reset', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Force Password Reset

Route::get('password/new', [ForceResetPasswordController::class, 'showResetForm'])
    ->name('password.forceReset')
    ->middleware('auth');

Route::post('password/new', [ForceResetPasswordController::class, 'reset'])
    ->name('password.forceResetUpdate')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::get('profile', [ProfileController::class, 'show'])
    ->name('profile.show')
    ->middleware('auth', 'verified', 'password.reset');

Route::get('profile/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit')
    ->middleware('auth', 'verified', 'password.reset');

Route::put('profile', [ProfileController::class, 'update'])
    ->name('profile.update')
    ->middleware('auth', 'verified', 'password.reset');

Route::delete('profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy')
    ->middleware('auth', 'verified', 'password.reset');

Route::post('profile/avatar', UpdateProfileAvatarController::class)
    ->name('profile.avatar')
    ->middleware('auth', 'verified', 'password.reset');

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::delete('notifications/{notification}', NotificationsController::class)
    ->name('notifications.read');
