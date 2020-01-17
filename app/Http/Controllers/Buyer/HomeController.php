<?php

namespace App\Http\Controllers\Buyer;

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
        return view('buyer.home');
    }
}
