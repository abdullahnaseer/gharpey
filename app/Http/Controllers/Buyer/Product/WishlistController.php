<?php

namespace App\Http\Controllers\Buyer\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $toggle = auth('buyer')->user()->wishlist_products()->toggle($product->id);

        if(count($toggle["attached"]) > 0)
            flash()->success('Product added to wishlist successfully.');
        else if(count($toggle["detached"]) > 0)
            flash()->success('Product removed from wishlist successfully.');

        return redirect()->back();
    }
}
