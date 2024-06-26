<?php

use Illuminate\Support\Facades\Route;

Route::get('orders', [
    'as' => 'admin.orders.index',
    'uses' => 'OrderController@index',
    'middleware' => 'can:admin.orders.index',
]);

Route::get('orders/{id}', [
    'as' => 'admin.orders.show',
    'uses' => 'OrderController@show',
    'middleware' => 'can:admin.orders.show',
]);

Route::put('orders/{order}/status', [
    'as' => 'admin.orders.status.update',
    'uses' => 'OrderStatusController@update',
    'middleware' => 'can:admin.orders.edit',
]);

Route::delete('orders/{ids?}', [
    'as' => 'admin.orders.destroy',
    'uses' => 'OrderController@destroy',
    'middleware' => 'can:admin.orders.edit',
]);

Route::post('orders/{order}/email', [
    'as' => 'admin.orders.email.store',
    'uses' => 'OrderEmailController@store',
    'middleware' => 'can:admin.orders.show',
]);

Route::get('orders/{order}/print', [
    'as' => 'admin.orders.print.show',
    'uses' => 'OrderPrintController@show',
    'middleware' => 'can:admin.orders.show',
]);

Route::post('orders/{order}/assign-driver', [
    'as' => 'admin.orders.assign_driver',
    'uses' => 'OrderController@assignDriver',
    'middleware' => 'can:admin.orders.edit',
]);

Route::delete('orders/{order}/unassign-driver', 'OrderController@unassignDriver')->middleware('can:admin.orders.edit')->name('admin.orders.unassign_driver');



