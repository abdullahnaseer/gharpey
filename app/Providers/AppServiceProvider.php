<?php

namespace App\Providers;

use App\Models\Buyer;
use Illuminate\Support\ServiceProvider;
use Laravel\Airlock\Airlock;
use Illuminate\Support\Facades\View;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Airlock::useUserModel(Buyer::class);
    }
}
