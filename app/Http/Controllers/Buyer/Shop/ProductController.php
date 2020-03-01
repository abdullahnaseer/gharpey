<?php

namespace App\Http\Controllers\Buyer\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Seller;
use Illuminate\Http\Request;
use Cart;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $shop_slug
     * @param string $product_slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $shop_slug, $product_slug)
    {
        $shop = Seller::where('shop_slug', $shop_slug)->with([])->firstOrFail();
        $product = $shop->products()
            ->where('slug', $product_slug)
            ->with(['reviews'])
            ->firstOrFail();

        $cart = \Cart::session($request->session()->get('_token'));
        $cartItem = $cart->get($product->id);

        return view('buyer.products.show', [
            'product' => $product,
            'cart_item' => $cartItem
        ]);
    }
}
