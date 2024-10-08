<?php

use Illuminate\Support\Facades\Route;

Route::get('checkout', 'CheckoutController@create')->middleware('auth', 'is_active')->name('checkout.create');
Route::post('checkout', 'CheckoutController@store')->middleware('auth', 'is_active')->name('checkout.store');

Route::get('checkout/{orderId}/complete', 'CheckoutCompleteController@store')->name('checkout.complete.store');
Route::get('checkout/complete', 'CheckoutCompleteController@show')->name('checkout.complete.show');

Route::get('checkout/{orderId}/payment-canceled', 'PaymentCanceledController@store')->name('checkout.payment_canceled.store');

