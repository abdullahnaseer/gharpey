<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
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

    }

    /**
     * Show the application home page for seller.
     *
     * @return Renderable
     */
    public function index()
    {
//        return view('seller.home');
        return redirect()->route('seller.login');
    }
}
