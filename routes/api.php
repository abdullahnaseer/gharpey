<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LogoutController@logout')->middleware('auth:airlock');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', 'UserController@user');

    Route::post('ckeditor/upload', 'CKEditorController@upload');
});

Route::resource('products', 'ProductController');
Route::get('search', 'ProductController@search');

