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

    Route::middleware('auth:admin')->group(function(){
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::namespace('Service')->prefix('services')->name('services.')->middleware([])->group(function () {
            Route::post('categories/json', 'CategoryController@json')->name('categories.json');
            Route::resource('categories', 'CategoryController')->only(['index', 'store', 'update', 'destroy']);
        });

        Route::namespace('Product')->prefix('products')->name('products.')->middleware([])->group(function () {
            Route::post('categories/json', 'CategoryController@json')->name('categories.json');
            Route::resource('categories', 'CategoryController')->only(['index', 'store', 'update', 'destroy']);
            Route::post('tags/json', 'TagController@json')->name('tags.json');
            Route::resource('tags', 'TagController')->only(['index', 'store', 'update', 'destroy']);
        });

        Route::post('services/json', 'Service\ServiceController@json')->name('services.json');
        Route::resource('services', 'Service\ServiceController');

        Route::prefix('users')->name('users.')->namespace('User')->group(function () {
            Route::post('moderators/json', 'ModeratorController@json')->name('moderators.json');
            Route::resource('moderators', 'ModeratorController')->only(['index', 'store', 'update', 'destroy']);
        });

        Route::namespace('Location')->prefix('location')->name('location.')->middleware([])->group(function () {
            Route::post('countries/json', 'CountryController@json')->name('countries.json');
            Route::post('countries/{country_id}/states/json', 'StateController@json')->name('countries.states.json');
            Route::post('countries/{country_id}/states/{state_id}/cities/json', 'CityController@json')->name('countries.states.cities.json');
            Route::post('countries/{country_id}/states/{state_id}/cities/{city_id}/areas/json', 'AreaController@json')->name('countries.states.cities.areas.json');

            Route::resource('countries', 'CountryController')->only(['index', 'store', 'update', 'destroy']);
            Route::resource('countries.states', 'StateController')->only(['index', 'store', 'update', 'destroy']);
            Route::resource('countries.states.cities', 'CityController')->only(['index', 'store', 'update', 'destroy']);
            Route::resource('countries.states.cities.areas', 'AreaController')->only(['index', 'store', 'update', 'destroy']);
        });
    });
});

Route::name('moderator.')->prefix('moderator')->namespace('Moderator')->group(function () {
    Auth::routes(['verify' => false, 'register' => false]);

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('users')->name('users.')->namespace('User')->group(function () {
        Route::post('sellers/json', 'SellerController@json')->name('sellers.json');
        Route::post('buyers/json', 'BuyerController@json')->name('buyers.json');

        Route::post('sellers/{seller_id}/approve', 'SellerController@approval')->name('sellers.approval');

        Route::resource('sellers', 'SellerController')->only(['index', 'store', 'update', 'destroy']);
        Route::resource('buyers', 'BuyerController')->only(['index', 'store', 'update', 'destroy']);
    });

    Route::post('products/json', 'Product\ProductController@json')->name('products.json');
    Route::resource('products', 'Product\ProductController')->only(['index', 'store', 'update', 'destroy']);

});

Route::name('seller.')->prefix('seller')->namespace('Seller')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    // Auth Routes Start
    Auth::routes(['verify' => true]);
    Route::get('phone/input', 'Auth\PhoneVerificationController@input')->name('phone_verification.input');
    Route::post('phone/store', 'Auth\PhoneVerificationController@store')->name('phone_verification.store');
    Route::get('phone/verify', 'Auth\PhoneVerificationController@show')->name('phone_verification.notice');
    Route::post('phone/verify', 'Auth\PhoneVerificationController@verify')->name('phone_verification.verify');
    Route::get('address/input', 'Auth\AddressController@input')->name('address.input');
    Route::post('address/store', 'Auth\AddressController@store')->name('address.store');
    Route::get('approval', 'Auth\ApprovalController@index')->name('approval');
    // Auth Routes End

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('products/json', 'Product\ProductController@json')->name('products.json');
    Route::resource('products', 'Product\ProductController')->only(['index', 'store', 'update', 'destroy']);

    Route::post('services/json', 'Service\ServiceController@json')->name('services.json');
    Route::resource('services', 'Service\ServiceController')->only(['index', 'store', 'update', 'destroy']);
});

Route::namespace('Buyer')->name('buyer.')->group(function () {
    Auth::routes(['verify' => true]);
    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('products', 'ProductController');

    // Service Routes
    Route::resource('services', 'ServiceController')->only(['index', 'show']);
    Route::resource('services.sellers', 'ServiceSellerController')->only(['show']);
    Route::post('/services/{service}', 'ServiceController@serviceRequest');
    Route::get('/service-categories/{id}', 'ServiceCategoryController@show');
    Route::get('/services/location/{state_code}', 'LocationController@state');
    Route::get('/services/location/{state_code}/{city_id}', 'LocationController@city');
    Route::get('/services/location/{state_code}/{city_slug}/{service_slug}', 'LocationController@service');
});


