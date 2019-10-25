<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name('admin.')->prefix('admin')->namespace('Admin')->group(function () {
    Auth::routes();
    Route::get('/', 'DashboardController@index')->name('dashboard');
});

Route::name('seller.')->prefix('seller')->namespace('Seller')->group(function () {
    Auth::routes();
    Route::get('/', 'DashboardController@index')->name('dashboard');
});

Route::get('/home', 'HomeController@index')->name('home');
