<?php

use Illuminate\Support\Facades\Route;

Route::post('createorder', 'OrderController@store');
Route::post('createcustomerorder', 'OrderController@storeCustomer')->middleware('authapi:api');
Route::get('getorders', 'OrderController@getOrders')->middleware('authapi:api');
