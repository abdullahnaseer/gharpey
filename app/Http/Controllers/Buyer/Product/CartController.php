<?php

namespace App\Http\Controllers\Buyer\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {


        $cart = Cart::session($request->session()->get('_token'));

        if ($request->has('clear')) {
            flash()->info("Cart Cleared...");
            $cart->clear();
        }

        return view('buyer.products.cart', [
            'cart' => $cart,
            'cart_items' => $cart->getContent()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $is_add_action = !$request->has('remove');

        $rowId = $product->id; // generate a unique() row ID

        $cart = Cart::session($request->session()->get('_token'));

        if ($is_add_action) {
            if ($product->inventory <= 0) {
                flash()->error('Product is out of stock!');
                return redirect()->back();
            }
            // add the product to cart
            $cart->add(array(
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => array(),
                'associatedModel' => $product
            ));

            flash()->success('Product added to cart successfully.');
        } else {
            // remove the product from cart
            $cart->remove($product->id);
            flash()->success('Product removed from cart successfully.');
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     * Update the cart.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'array',
            'quantity.*' => 'integer|min:1,max:1000',
        ]);

        $cart = Cart::session($request->session()->get('_token'));

        $products = $request->input('product_id', []);
        $quantities = $request->input('quantity', []);
        for ($i = 0, $iMax = count($products); $i < $iMax; $i++) {
            $product = Product::findOrFail($products[$i]);
            if ($quantities[$i] <= $product->inventory) {
                $cart->update($products[$i], array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $quantities[$i]
                    ),
                ));
            } else {
                $cart->update($products[$i], array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $product->inventory
                    ),
                ));
                flash()->error('Product "' . $product->name . '" not has enough stock');
            }

        }

        flash()->success('Cart Updated Successfully.');
        return redirect()->back();
    }

}
