<?php

use Illuminate\Support\Facades\Route;


Route::post('login', 'ApiAuthController@login');
Route::post('register', 'ApiAuthController@register');

Route::get('user', 'ApiAuthController@getUser')->middleware('authapi:api');


