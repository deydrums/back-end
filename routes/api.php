<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\RenewTokenController;
use App\Http\Controllers\Auth\UpdateController;
use App\Http\Controllers\Auth\UploadImageController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| API AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::post('/register', RegisterController::class)->name('auth.register');
    Route::post('/login', LoginController::class)->name('auth.login');
    Route::get('/logout', LogoutController::class)
        ->middleware('auth:sanctum')
        ->name('auth.logout');

    Route::post('/forgot-password', PasswordResetLinkController::class)
        ->name('auth.password.email');

    Route::post('/reset-password', NewPasswordController::class)
        ->name('auth.password.update');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('auth.verification.verify');

    Route::post('/email-verification-notification', EmailVerificationNotificationController::class)
        ->middleware(['auth:sanctum', 'throttle:6,1'])
        ->name('auth.verification.send');

    Route::post('/confirm-password', ConfirmablePasswordController::class)
        ->middleware('auth:sanctum')
        ->name('auth.password.confirm');

    Route::post('/renew', RenewTokenController::class)
        ->middleware('auth:sanctum')
        ->name('auth.renew.token');


    Route::put('/update', UpdateController::class)
        ->middleware('auth:sanctum')
        ->name('auth.update.user');

    Route::post('/upload', UploadImageController::class)
        ->middleware('auth:sanctum')
        ->name('auth.upload.image');
    
});

/*
|--------------------------------------------------------------------------
| API USER ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('user')->group(function () {
    Route::get('/get-users', [UserController::class, 'getUsers'])
        ->name('user.get.users');
    Route::get('/get-avatar/{filename}/{ext}', [UserController::class, 'getAvatar'])
        ->name('user.get.avatar');;
    Route::put('/set-admin/{id}/{action}', [UserController::class, 'setAdmin'])
        ->middleware('auth:sanctum', 'verified','isRole:_ADMIN')
        ->name('user.set.admin');;
});

Route::get('/verified-middleware-example', function () {
    return response()->json([
        'message' => 'the email account is already confirmed now you are able to see this message...',
    ]);
 })->middleware('auth:sanctum', 'verified');