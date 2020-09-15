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
});
