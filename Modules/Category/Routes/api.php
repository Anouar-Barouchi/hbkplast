<?php

use Illuminate\Support\Facades\Route;

Route::get('categories', 'CategoryController@index');

Route::get('categories/{category}/products', 'CategoryProductController@index')->name('categories.products.index');
