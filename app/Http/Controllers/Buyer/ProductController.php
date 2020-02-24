<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Cart;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::whereNotNull('id');
        if($request->has('category'))
            $products = $products->where('category_id', $request->input('category'));

        if($request->has('price-min'))
            $products = $products->where('price', '>=', $request->input('price-min'));

        if($request->has('price-max'))
            $products = $products->where('price', '<=', $request->input('price-max'));

        $products = $products->paginate(15);

        $products->each(function ($product) use ($request) {
            $product->cart_item = Cart::session($request->session()->get('_token'))->get($product->id);
        });

        return view('buyer.products.index', [
            'products' => $products,
            'categories' => ProductCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $cartItem = Cart::session($request->session()->get('_token'))->get($product->id);
        return view('buyer.products.show', [
            'product' => $product,
            'cart_item' => $cartItem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
