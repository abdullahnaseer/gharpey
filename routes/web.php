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
        Route::get('/get-chart-data/{model_name}', 'DashboardController@getChartData')->name('get-chart-data');

        Route::get('/payments', 'PaymentController@get');
        Route::post('/payments', 'PaymentController@post');

        Route::namespace('Service')->prefix('services')->name('services.')->middleware([])->group(function () {
            Route::post('categories/json', 'CategoryController@json')->name('categories.json');
            Route::resource('categories', 'CategoryController')->only(['index', 'store', 'update', 'destroy']);
//            Route::post('categories/{category_id}/subcategories/json', 'SubCategoryController@json')->name('categories.subcategories.json');
//            Route::resource('categories.subcategories', 'SubCategoryController')->only(['index', 'store', 'update', 'destroy']);
        });

        Route::namespace('Product')->prefix('products')->name('products.')->middleware([])->group(function () {
            Route::post('categories/json', 'CategoryController@json')->name('categories.json');
            Route::resource('categories', 'CategoryController')->only(['index', 'store', 'update', 'destroy']);
            Route::post('categories/{category_id}/subcategories/json', 'SubCategoryController@json')->name('categories.subcategories.json');
            Route::resource('categories.subcategories', 'SubCategoryController')->only(['index', 'store', 'update', 'destroy']);
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

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/overview', 'ProfileController@overview')->name('overview');
            Route::get('/pass', 'ProfileController@change_password')->name('pass');
            Route::get('/setting', 'ProfileController@email_settings')->name('setting');
            Route::get('/personal', 'ProfileController@personal')->name('personal');

            Route::post('/', 'ProfileController@update')->name('update');
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

        Route::resource('sellers', 'SellerController')->only(['index', 'show', 'store', 'update', 'destroy']);
        Route::resource('buyers', 'BuyerController')->only(['index', 'show', 'store', 'update', 'destroy']);
    });

    Route::post('products/orders/json', 'Product\OrderController@json')->name('orders.json');
    Route::resource('products/orders', 'Product\OrderController')->only(['index', 'edit']);

    Route::post('products/json', 'Product\ProductController@json')->name('products.json');
    Route::resource('products', 'Product\ProductController')->only(['index', 'store', 'update', 'destroy']);

    Route::post('services/requests/json', 'Service\ServiceRequestController@json')->name('requests.json');
    Route::resource('services/requests', 'Service\ServiceRequestController')->only(['index', 'edit']);

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/overview', 'ProfileController@overview')->name('overview');
        Route::get('/pass', 'ProfileController@change_password')->name('pass');
        Route::get('/setting', 'ProfileController@email_settings')->name('setting');
        Route::get('/personal', 'ProfileController@personal')->name('personal');

        Route::post('/', 'ProfileController@update')->name('update');
    });
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

    Route::middleware(['auth:seller', 'seller.approved'])->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/finance', 'FinanceController@index')->name('finance');
        Route::post('/finance/', 'FinanceController@payment')->name('finance.payment');
        Route::get('/withdraws/', 'WithdrawController@index')->name('withdraws');
        Route::post('/withdraws/json', 'WithdrawController@json')->name('withdraws.json');



        Route::post('products/orders/json', 'Product\OrderController@json')->name('orders.json');
        Route::resource('products/orders', 'Product\OrderController')->only(['index', 'edit']);

        Route::post('questions/json', 'QuestionController@json')->name('questions.json');
        Route::resource('questions', 'QuestionController')->only(['index', 'update']);

        Route::post('products/json', 'Product\ProductController@json')->name('products.json');
        Route::resource('products', 'Product\ProductController')->only(['index', 'store', 'update', 'destroy']);


        Route::post('services/requests/json', 'Service\ServiceRequestController@json')->name('requests.json');
        Route::resource('services/requests', 'Service\ServiceRequestController');

        Route::post('services/json', 'Service\ServiceController@json')->name('services.json');
        Route::resource('services', 'Service\ServiceController');



        Route::name('account.')->prefix('account')->namespace('Account')->group(function () {
            Route::get('/', 'AccountController@index')->name('index');

            Route::get('/settings/shop', 'AccountController@getShop')->name('getShop');
            Route::get('/settings/info', 'AccountController@getInfo')->name('getInfo');
            Route::get('/settings/address', 'AccountController@getAddress')->name('getAddress');
            Route::get('/settings/password', 'AccountController@getPassword')->name('getPassword');

            Route::post('/settings/shop', 'AccountController@updateShop')->name('updateShop');
            Route::post('/settings/info', 'AccountController@updateInfo')->name('updateInfo');
            Route::post('/settings/address', 'AccountController@updateAddress')->name('updateAddress');
            Route::post('/settings/password', 'AccountController@updatePassword')->name('updatePassword');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/overview', 'ProfileController@overview')->name('overview');
            Route::get('/pass', 'ProfileController@change_password')->name('pass');
            Route::get('/setting', 'ProfileController@email_settings')->name('setting');
            Route::get('/personal', 'ProfileController@personal')->name('personal');

            Route::post('/', 'ProfileController@update')->name('update');
        });
    });
});

Route::namespace('Buyer')->name('buyer.')->group(function () {
    Auth::routes(['verify' => true]);

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('products', 'ProductController');
    Route::resource('products.questions', 'Product\ProductQuestionsController')->middleware('auth:buyer');

    Route::resource('shop.product', 'Shop\ProductController');
    Route::resource('shop', 'Shop\ShopController');

    // Product Cart Order Checkout
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
    Route::resource('services', 'Service\ServiceController')->only(['index', 'show']);
    Route::resource('services.sellers', 'Service\ServiceSellerController')->only(['show', 'store']);
    Route::resource('services.sellers.questions', 'Service\ServiceQuestionsController')->middleware('auth:buyer');
//    Route::resource('service_requests', 'Service\ServiceRequestController')->only(['show']);

    // Service Request Checkout Routes
    Route::get('service_request/{service_request_id}/checkout', 'Service\CheckoutController@getShipping')->name('service.checkout.shipping.get');
    Route::post('service_request/{service_request_id}/checkout', 'Service\CheckoutController@postShipping')->name('service.checkout.shipping.post');
    Route::get('service_request/{service_request_id}/checkout/payment', 'Service\CheckoutController@getPayment')->name('service.checkout.payment.get');
    Route::post('service_request/{service_request_id}/checkout/payment', 'Service\CheckoutController@postPayment')->name('service.checkout.payment.post');
    Route::post('service_request/{service_request_id}/checkout/charge', 'Service\CheckoutController@charge')->name('service.checkout.charge');
    Route::get('service_request/{service_request_id}/checkout/success', 'Service\CheckoutController@success')->name('service.checkout.success');

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
        Route::resource('service-requests.reviews', 'ServiceRequestReviewController')->only(['index', 'create', 'store']);

        Route::resource('wishlist', 'WishlistController')->only(['index']);
        Route::resource('notifications', 'NotificationController')->only(['index']);

        Route::resource('support', 'SupportController');
    });
});


