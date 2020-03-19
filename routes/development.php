<?php

use App\PlatformDev\Users\Controllers\MailsToUsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ⬆️ All these routes above will go live soon ⬆️
|
| The following ones are and always will be development routes.
|--------------------------------------------------------------------------
*/

// Mails to users...
Route::get('/mails/user-registered', [MailsToUsersController::class, 'userRegistered']);
Route::get('/mails/user-requested-verification', [MailsToUsersController::class, 'userRequestedVerification']);
Route::get('/mails/user-verified', [MailsToUsersController::class, 'userVerified']);
Route::get('/mails/user-forgot-password', [MailsToUsersController::class, 'userForgotPassword']);
