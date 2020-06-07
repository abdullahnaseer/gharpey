<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $category = null;
        $products = Product::where('inventory', '>', 0);
        if ($request->has('q'))
            $products = $products->where('name', 'like', '%' . $request->input('q') . '%');

        if ($request->has('category')) {
            $category_id = $request->input('category');
            $category = ProductCategory::findOrFail($category_id);
            $products = $products
                ->whereHas('category', function (Builder $query) use ($category_id) {
                    $query->where('category_id', $category_id) // Depth 0
                    ->orWhereHas('parent_category', function (Builder $query) use ($category_id) {
                        $query->where('id', $category_id)  // Depth 1
                        ->orWhereHas('parent_category', function (Builder $query) use ($category_id) {
                            $query->where('id', $category_id);  // Depth 2
                        });
                    });
                });
        }

        if ($request->has('price-min'))
            $products = $products->where('price', '>=', $request->input('price-min'));

        if ($request->has('price-max'))
            $products = $products->where('price', '<=', $request->input('price-max'));

        $products = $products->with([])->paginate(15);

        $cart = Cart::session($request->session()->get('_token'));

        $products->each(function ($product) use ($request, $cart) {
            $product->cart_item = $cart->get($product->id);
        });

        return view('buyer.products.index', [
            'products' => $products,
            'categories' => ProductCategory::whereNull('parent_id')->get(),
            'category' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $slug
     * @return mixed
     */
    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->with(['reviews'])->firstOrFail();

        $cookie = $request->cookie('cart');
        if (is_null($cookie)) {
            $cookie = Str::random(32);
            cookie('cart', $cookie, 60 * 24 * 365);
        }

        $cart = Cart::session($request->session()->get('_token'));
        $cartItem = $cart->get($product->id);

        return view('buyer.products.show', [
            'product' => $product,
            'cart_item' => $cartItem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy($id)
    {
        //
    }
}
