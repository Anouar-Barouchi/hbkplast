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
Route::get('get-missions', [DriverController::class, 'getMissions'])->middleware('authapi:driver');
Route::post('accept-mission', [DriverController::class, 'acceptMission'])->middleware('authapi:driver');

Route::post('orders/{order}/change-status', [DriverController::class, 'changeOrderStatus'])->middleware('authapi:driver');



