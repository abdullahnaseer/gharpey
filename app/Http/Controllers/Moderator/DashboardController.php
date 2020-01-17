<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:moderator');
    }

    /**
     * Show the application dashboard for moderator.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('moderator.dashboard');
    }
}
