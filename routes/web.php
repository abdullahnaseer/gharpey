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
    Route::get('/', 'HomeController@index')->name('home');
    Auth::routes(['verify' => false, 'register' => false]);
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::namespace('Location')->prefix('location')->name('location.')->middleware([])->group(function () {
        Route::resource('countries', 'CountryController')->only(['index', 'store', 'update', 'destroy']);
        Route::resource('countries.states', 'StateController')->only(['index', 'store', 'update', 'destroy']);
        Route::resource('countries.states.cities', 'CityController')->only(['index', 'store', 'update', 'destroy']);
        Route::resource('countries.states.cities.areas', 'AreaController')->only(['index', 'store', 'update', 'destroy']);
    });
});

Route::name('seller.')->prefix('seller')->namespace('Seller')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Auth::routes(['verify' => true]);
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('phone/input', 'Auth\PhoneVerificationController@input')->name('phone_verification.input');
    Route::post('phone/store', 'Auth\PhoneVerificationController@store')->name('phone_verification.store');
    Route::get('phone/verify', 'Auth\PhoneVerificationController@show')->name('phone_verification.notice');
    Route::post('phone/verify', 'Auth\PhoneVerificationController@verify')->name('phone_verification.verify');

    Route::get('address/input', 'Auth\AddressController@input')->name('address.input');
    Route::post('address/store', 'Auth\AddressController@store')->name('address.store');
});

Route::get('/home', 'HomeController@index')->name('home');

