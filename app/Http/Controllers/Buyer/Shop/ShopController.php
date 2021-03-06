<?php

namespace App\Http\Controllers\Buyer\Shop;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShopController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $shop_slug
     * @param string $product_slug
     * @return mixed
     */
    public function show(Request $request, $shop_slug)
    {
        $data['shop'] = Seller::where('shop_slug', $shop_slug)->with(['business_location', 'business_location.city'])->firstOrFail();

        if ($request->has('services'))
            $data['services'] = $data['shop']->services()
                ->withCount('reviews')
                ->orderBy('reviews_count', 'desc')
                ->get();
        else {
            $data['products'] = $data['shop']->products()
                ->withCount('reviews')
                ->orderBy('reviews_count', 'desc')
                ->paginate(15);

            $cart = Cart::session($request->session()->get('_token'));

            $data['products']->each(function ($product) use ($request, $cart) {
                $product->cart_item = $cart->get($product->id);
            });
        }

        return view('buyer.shop.show', $data);
    }
}
