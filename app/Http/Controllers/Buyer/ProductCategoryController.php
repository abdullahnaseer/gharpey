<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        //
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
     * @param ServiceCategory $serviceCategory
     * @return mixed
     */
    public function show($slug)
    {
//        $productCategory = ProductCategory::where('slug', $slug)->whereHas('products.seller')->with(['products'])->firstOrFail();

//        $productCategory = ProductCategory::where('slug', $slug)->with([
//            'products' => fn($q) => $q->whereHas('seller')
//        ])->firstOrFail();

//        return view('buyer.products.categories.show', ['category' => $productCategory]);
    }

    /**
     * Display our services.
     *
     * @return mixed
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceCategory $serviceCategory
     * @return mixed
     */
    public function edit(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ServiceCategory $serviceCategory
     * @return mixed
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceCategory $serviceCategory
     * @return mixed
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        //
    }
}
