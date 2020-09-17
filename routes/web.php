<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});

Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@check')->name('auth.check');
Route::delete('/login', 'AuthController@destroy')->name('auth.destroy');

Route::middleware('is.online')->group(function(){
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/table', 'TableController')->middleware('is.admin');
    Route::resource('/user', 'UserController')->middleware('is.admin');
    Route::resource('/canteen-menu', 'CanteenMenuController')->middleware('is.admin');
    Route::resource('/order', 'OrderController')->middleware('is.admin.waiter');
    Route::resource('/transaction', 'TransactionController')->middleware('is.admin.cashier');
    
    Route::get('/order/get/table', 'OrderController@get_table_ordered')->name('order.get.table')->middleware('is.admin.waiter');
    Route::post('/order/done', 'OrderController@order_done')->name('order.done')->middleware('is.admin.waiter');
    Route::post('/order/cancel', 'OrderController@order_cancel')->name('order.cancel')->middleware('is.admin.waiter');

    Route::get('/transaction/get/table', 'TransactionController@get_table_transaction')->name('transaction.get.table')->middleware('is.admin.cashier');
    Route::get('/transaction/get/invoice', 'TransactionController@get_invoice')->name('transaction.get.invoice')->middleware('is.admin.cashier');
});
