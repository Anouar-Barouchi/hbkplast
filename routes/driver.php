<?php

use FleetCart\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

Route::get('hello', function (){
    return 'hello';
});

Route::get('user', [DriverController::class, 'getUser'])->middleware('authapi:driver');

Route::post('login', [DriverController::class, 'login']);

Route::post('register', [DriverController::class, 'register']);
Route::post('set-token', [DriverController::class, 'setDeviceToken'])->middleware('authapi:driver');
Route::get('get-missions', [DriverController::class, 'getMissions'])->middleware('authapi:api');

