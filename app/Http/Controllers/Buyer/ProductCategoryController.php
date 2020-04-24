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
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceCategory $serviceCategory
     * @return Response
     */
    public function show($slug)
    {
        $productCategory = ProductCategory::where('slug', $slug)->with('products')->firstOrFail();

        return view('buyer.products.categories.show', ['category' => $productCategory]);
    }

    /**
     * Display our services.
     *
     * @return Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceCategory $serviceCategory
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceCategory $serviceCategory
     * @return Response
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        //
    }
}
