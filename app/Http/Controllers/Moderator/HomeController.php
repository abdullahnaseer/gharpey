<?php

namespace App\Http\Controllers\Moderator;

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
     * Show the application home page for moderator.
     *
     * @return Renderable
     */
    public function index()
    {
        return redirect()->route('moderator.login');
//        return view('moderator.home');
    }
}
