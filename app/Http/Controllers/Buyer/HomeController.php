<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application homepage.
     *
     * @return Renderable
     */
    public function index()
    {
        $data['popular_services'] = Service::whereHas('service_sellers')
            ->with(['category'])
            ->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(10)->get();

        $data['popular_products'] = Product::whereHas('seller')->with([
            'category',
            'seller' => fn($q) => $q->withTrashed(),
            'reviews'
        ])->inStock()
            ->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(10)->get();

        return view('buyer.home', $data);
    }
}
