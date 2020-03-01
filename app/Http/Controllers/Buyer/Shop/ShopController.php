<?php

namespace App\Http\Controllers\Buyer\Shop;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $shop_slug
     * @param string $product_slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $shop_slug)
    {
        $data['shop'] = Seller::where('shop_slug', $shop_slug)->with(['business_location', 'business_location.city'])->firstOrFail();

        if($request->has('services'))
            $data['services'] = $data['shop']->services()->get();
        else
        {
            $data['products'] = $data['shop']->products()->paginate(15);

            $cart = \Cart::session($request->session()->get('_token'));

            $data['products']->each(function ($product) use ($request, $cart) {
                $product->cart_item = $cart->get($product->id);
            });
        }

//        return $data;

        return view('buyer.shop.show', $data);
    }
}
