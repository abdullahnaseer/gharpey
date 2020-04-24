<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApprovalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:seller');
        $this->middleware('seller.verified');
    }

    /**
     * Show the approval status.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        return $request->user('seller')->isApproved()
            ? redirect()->route('seller.dashboard')
            : view('seller.auth.approval');
    }
}
