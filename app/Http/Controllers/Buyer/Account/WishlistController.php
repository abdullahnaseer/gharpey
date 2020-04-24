<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['products'] = auth('buyer')->user()->wishlist_products()->orderBy('created_at', 'desc')->get();
        return view('buyer.account.wishlist', $data);
    }
}
