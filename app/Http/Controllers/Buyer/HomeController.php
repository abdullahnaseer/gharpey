<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application homepage.
     *
     * @return Renderable
     */
    public function index()
    {
        $data['popular_services'] = Service::with(['category'])->take(10)->get();
        $data['popular_products'] = Product::with(['category', 'seller'])->take(10)->get();

        return view('buyer.home', $data);
    }
}
