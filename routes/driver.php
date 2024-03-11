<?php

use FleetCart\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;

Route::get('hello', function (){
    return 'hello';
});

Route::get('user', [DriverController::class, 'getUser'])->middleware('authapi:driver');

Route::post('login', [DriverController::class, 'login']);