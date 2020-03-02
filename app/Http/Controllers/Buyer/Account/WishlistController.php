<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = auth('buyer')->user()->wishlist_products()->orderBy('created_at', 'desc')->get();
        return view('buyer.account.wishlist', $data);
    }
}
