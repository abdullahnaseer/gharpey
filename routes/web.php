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

    Route::post('products/orders/json', 'Product\OrderController@json')->name('orders.json');
    Route::resource('products/orders', 'Product\OrderController')->only(['index', 'edit']);

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
    Route::post('products/orders/json', 'Product\OrderController@json')->name('orders.json');
    Route::resource('products/orders', 'Product\OrderController')->only(['index', 'edit']);
    Route::post('products/json', 'Product\ProductController@json')->name('products.json');
    Route::resource('products', 'Product\ProductController')->only(['index', 'store', 'update', 'destroy']);

    Route::post('services/json', 'Service\ServiceController@json')->name('services.json');
    Route::resource('services', 'Service\ServiceController')->only(['index', 'store', 'update', 'destroy']);
});

Route::namespace('Buyer')->name('buyer.')->group(function () {
    Auth::routes(['verify' => true]);

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('products', 'ProductController');

    Route::get('checkout', 'Product\CheckoutController@getShipping')->name('checkout.shipping.get');
    Route::post('checkout', 'Product\CheckoutController@postShipping')->name('checkout.shipping.post');

    Route::get('checkout/payment', 'Product\CheckoutController@getPayment')->name('checkout.payment.get');
    Route::post('checkout/payment', 'Product\CheckoutController@postPayment')->name('checkout.payment.post');

    Route::post('checkout/charge', 'Product\CheckoutController@charge')->name('checkout.charge');

    Route::get('checkout/success', 'Product\CheckoutController@success')->name('checkout.success');

    Route::resource('cart', 'Product\CartController')->only(['index', 'store']);
    Route::resource('products.cart', 'Product\CartController')->only(['create', 'store']);
    Route::resource('products.wishlist', 'Product\WishlistController')->only(['index', 'create', 'store']);

    // Service Routes
    Route::resource('services', 'ServiceController')->only(['index', 'show', 'store']);
    Route::resource('services.sellers', 'ServiceSellerController')->only(['show']);

    Route::name('account.')->prefix('account')->namespace('Account')->middleware('auth:buyer')->group(function () {
        Route::get('/', 'AccountController@index')->name('index');

        Route::get('/settings/info', 'AccountController@getInfo')->name('getInfo');
        Route::get('/settings/address', 'AccountController@getAddress')->name('getAddress');
        Route::get('/settings/password', 'AccountController@getPassword')->name('getPassword');

        Route::post('/settings/info', 'AccountController@updateInfo')->name('updateInfo');
        Route::post('/settings/address', 'AccountController@updateAddress')->name('updateAddress');
        Route::post('/settings/password', 'AccountController@updatePassword')->name('updatePassword');

        Route::resource('orders', 'ProductOrderController')->only(['index']);

        Route::resource('orders.reviews', 'ProductOrderReviewController')->only(['index', 'create', 'store']);

        Route::resource('service-requests', 'ServiceRequestController')->only(['index']);
        Route::resource('wishlist', 'WishlistController')->only(['index']);
    });
});


