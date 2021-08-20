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
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Ui\UiController;
use App\Http\Controllers\Portafolio\PortafolioController;

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

/*
|--------------------------------------------------------------------------
| API BLOG ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('entry')->group(function () {
    Route::post('/create-entry', [BlogController::class, 'createEntry'])
        ->middleware('auth:sanctum', 'verified');

    Route::delete('/delete/{id}', [BlogController::class, 'deleteEntry'])
        ->middleware('auth:sanctum', 'verified');

    Route::put('/update-entry/{id}', [BlogController::class, 'updateEntry'])
        ->middleware('auth:sanctum', 'verified');

    Route::get('/get-entries', [BlogController::class, 'getEntries']);

    Route::get('/get-entry/{id}', [BlogController::class, 'getEntry']);

    Route::post('/upload/{id}', [BlogController::class, 'uploadImage'])
        ->middleware('auth:sanctum', 'verified');

    Route::get('/get-image/{filename}/{ext}', [BlogController::class, 'getImage'])
        ->name('entry.get.img');;
});


Route::prefix('category')->group(function () {
    Route::post('/create-category', [CategoryController::class, 'createCategory'])
        ->middleware('auth:sanctum', 'verified');

    Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory'])
        ->middleware('auth:sanctum', 'verified');

    Route::get('/get-categories', [CategoryController::class, 'getCategories']);

    Route::delete('/delete/{id}', [CategoryController::class, 'deleteCategory'])
        ->middleware('auth:sanctum', 'verified','isRole:_ADMIN');

    Route::get('/get-category/{id}', [CategoryController::class, 'getCategory']);
});

/*
|--------------------------------------------------------------------------
| API UI ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('ui')->group(function () {
    Route::post('/send-contactEmail', [UiController::class, 'contactEmail']);
});

/*
|--------------------------------------------------------------------------
| API PORTAFOLIO ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('portafolio')->group(function () {
    Route::post('/create-project', [PortafolioController::class, 'createProject'])
        ->middleware('auth:sanctum', 'verified');

    Route::get('/get-projects', [PortafolioController::class, 'getProjects']);

    Route::put('/update-project/{id}', [PortafolioController::class, 'updateProject'])
        ->middleware('auth:sanctum', 'verified');

    Route::delete('/delete/{id}', [PortafolioController::class, 'deleteProject'])
        ->middleware('auth:sanctum', 'verified','isRole:_ADMIN');
});


Route::get('/verified-middleware-example', function () {
    return response()->json([
        'message' => 'the email account is already confirmed now you are able to see this message...',
    ]);
 })->middleware('auth:sanctum', 'verified');