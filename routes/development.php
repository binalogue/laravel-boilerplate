<?php

use App\PlatformDev\Mails\Controllers\MailsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ⬆️ All these routes above will go live soon ⬆️
|
| The following ones are and always will be development routes.
|--------------------------------------------------------------------------
*/

// Mails to users...
Route::get('/mails/users/registered', [MailsController::class, 'userRegistered']);
Route::get('/mails/users/requested-verification', [MailsController::class, 'userRequestedVerification']);
Route::get('/mails/users/verified', [MailsController::class, 'userVerified']);
Route::get('/mails/users/forgot-password', [MailsController::class, 'userForgotPassword']);
