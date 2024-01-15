<?php

use Illuminate\Support\Facades\Route;




Route::get('products', 'ProductController@index');
Route::get('products/{slug}', 'ProductController@show');