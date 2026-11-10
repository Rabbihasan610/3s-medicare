<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AuthorizationController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ForgotPasswordController::class)->prefix('password')->group(function () {
    Route::post('email', 'sendResetCodeEmail');
    Route::post('verify-code', 'verifyCode');
    Route::post('set-new-password', 'resetPassword');
});



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('check-user', [AuthController::class, 'checkUser']);

Route::middleware('auth:api')->group(function () {
    Route::controller(AuthorizationController::class)->group(function () {
        Route::get('resend-verify', 'sendVerifyCode');
        Route::post('verify-email', 'emailVerification');
        Route::post('verify-mobile', 'mobileVerification');
    });

    Route::post('user-data', [AuthController::class, 'userData']);
});


Route::get('/countries', [ApiController::class, 'countries']);
Route::get('/all-countries', [ApiController::class, 'allcountries']);
Route::get('/cities/{country_id}', [ApiController::class, 'cities']);

Route::middleware(['auth:api', 'check.status.api'])->group(function(){

    Route::controller(ProfileController::class)->prefix('user')->group(function () {
        Route::get('profile-setting', 'profile');
        Route::post('profile-setting', 'submitProfile');
        Route::post('change-password', 'submitPassword');
    });

    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('statics', 'dashboard');
    });
});

