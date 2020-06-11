<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $product_categories = ProductCategory::with(['products', 'products.seller', 'products.reviews'])->get();

        foreach ($product_categories as $product_category) {
            foreach ($product_category->products as $product) {
                $product->reviews_cnt = $product->reviews_count;
                $product->reviews_avg = $product->reviews_average;
                $product->quantity = 0;
            }
        }

        return $product_categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Builder[]|Collection
     */
    public function search(Request $request)
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

        $products = $products->with([
            'seller',
            'reviews',
        ])->get();

        foreach ($products as $product) {
            $product->reviews_cnt = $product->reviews_count;
            $product->reviews_avg = $product->reviews_average;
            $product->quantity = 0;
        }

        return $products;
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
     * @param int $id
     * @return mixed
     */
    public function show($id)
    {
        return Product::with(['seller'])->findOrFail($id);
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
