<?php
use FleetCart\Http\Controllers\DeviceController;


Route::post('set-token', [DeviceController::class, 'store']);


Route::group(['prefix' => 'v2/auth', 'middleware' => ['app_language']], function() {
    Route::post('login', 'App\Http\Controllers\Api\V2\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\Api\V2\AuthController@signup');
    Route::post('social-login', 'App\Http\Controllers\Api\V2\AuthController@socialLogin');
    Route::post('password/forget_request', 'App\Http\Controllers\Api\V2\PasswordResetController@forgetRequest');
    Route::post('password/confirm_reset', 'App\Http\Controllers\Api\V2\PasswordResetController@confirmReset');
    Route::post('password/resend_code', 'App\Http\Controllers\Api\V2\PasswordResetController@resendCode');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', 'App\Http\Controllers\Api\V2\AuthController@logout');
        Route::get('user', 'App\Http\Controllers\Api\V2\AuthController@user');
    });
    Route::post('resend_code', 'App\Http\Controllers\Api\V2\AuthController@resendCode');
    Route::post('confirm_code', 'App\Http\Controllers\Api\V2\AuthController@confirmCode');
});