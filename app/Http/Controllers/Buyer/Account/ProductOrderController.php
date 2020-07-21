<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('buyer.account.orders.index', [
            'orders' => auth()->user()->orders()->with([
                'items',
                'items.product' => fn($q) => $q->withTrashed()
            ])->latest()->get()
        ]);
    }
}
