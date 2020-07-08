<?php

use App\Platform\Home\Controllers\HomeController;
use App\Platform\Notifications\Controllers\NotificationsController;
use App\Platform\Users\Controllers\Auth\ForceResetPasswordController;
use App\Platform\Users\Controllers\Auth\ForgotPasswordController;
use App\Platform\Users\Controllers\Auth\LoginController;
use App\Platform\Users\Controllers\Auth\RegisterController;
use App\Platform\Users\Controllers\Auth\ResetPasswordController;
use App\Platform\Users\Controllers\Auth\SocialiteController;
use App\Platform\Users\Controllers\Auth\VerificationController;
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
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showPreRegisterPage'])->name('register');
    Route::get('/register/email', [RegisterController::class, 'showRegisterPage'])->name('register.email');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Socialite Routes...
Route::middleware('guest')->group(function () {
    Route::get('/oauth/{driver}', [SocialiteController::class, 'redirectToProvider'])->where('driver', implode('|', config('socialite.drivers')))->name('oauth');
    Route::get('/oauth/{driver}/callback', [SocialiteController::class, 'handleProviderCallback'])->where('driver', implode('|', config('socialite.drivers')));
});

// Password Reset Routes...
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Force Password Reset Routes...
Route::middleware('auth')->group(function () {
    Route::get('/password/new', [ForceResetPasswordController::class, 'showResetForm'])->name('password.force_reset');
    Route::post('/password/new', [ForceResetPasswordController::class, 'reset'])->name('password.force_reset_update');
});

// Email Verification Routes...
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware('signed', 'throttle:6,1');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend')->middleware('throttle:6,1');
});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'password.reset'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('remember');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profile/avatar', UpdateProfileAvatarController::class)->name('profile.avatar');
});

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::delete('/notifications/{notification}', NotificationsController::class)->name('notifications.read');
