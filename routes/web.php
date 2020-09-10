<?php

use App\Platform\Home\Controllers\HomeController;
use App\Platform\Notifications\Controllers\NotificationsController;
use App\Platform\Auth\Controllers\EmailVerificationController;
use App\Platform\Auth\Controllers\ForceResetPasswordController;
use App\Platform\Auth\Controllers\ForgotPasswordController;
use App\Platform\Auth\Controllers\LoginController;
use App\Platform\Auth\Controllers\PreRegisterController;
use App\Platform\Auth\Controllers\RegisterController;
use App\Platform\Auth\Controllers\ResetPasswordController;
use App\Platform\Auth\Controllers\SocialiteController;
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

Route::get('/', HomeController::class)->name('home');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

// Authentication Routes...
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Pre Registration Routes...
Route::middleware('guest')->group(function () {
    Route::get('register', [PreRegisterController::class, 'showPreRegisterForm'])->name('preRegister.form');
});

// Registration Routes...
Route::middleware('guest')->group(function () {
    Route::get('register/email', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
});

// Email Verification Routes...
Route::middleware('auth')->group(function () {
    Route::get('email/verify', [EmailVerificationController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('signed', 'throttle:6,1');
    Route::post('email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend')->middleware('throttle:6,1');
});

// Socialite Routes...
Route::middleware('guest')->group(function () {
    Route::get('oauth/{driver}', [SocialiteController::class, 'redirectToProvider'])->where('driver', implode('|', config('socialite.drivers')))->name('oauth');
    Route::get('oauth/{driver}/callback', [SocialiteController::class, 'handleProviderCallback'])->where('driver', implode('|', config('socialite.drivers')))->name('oauth.callback');
});

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Force Password Reset Routes...
Route::middleware('auth')->group(function () {
    Route::get('password/new', [ForceResetPasswordController::class, 'showResetForm'])->name('password.forceReset');
    Route::post('password/new', [ForceResetPasswordController::class, 'reset'])->name('password.forceResetUpdate');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'password.reset'])->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('profile/avatar', UpdateProfileAvatarController::class)->name('profile.avatar');
});

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::delete('notifications/{notification}', NotificationsController::class)->name('notifications.read');
