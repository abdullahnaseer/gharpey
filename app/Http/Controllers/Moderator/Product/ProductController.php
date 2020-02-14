<?php

namespace App\Http\Controllers\Moderator\Product;

use App\Http\Controllers\Controller;
use App\Models\Moderator;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Str;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:moderator,moderator');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $records = Product::with([])->get();
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('moderator.products.index', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:1000',
            'featured_image' => 'required|image',
            'category_id' => 'required|numeric|exists:product_categories,id',
        ]);

        $fields = $request->only(['name', 'description', 'category_id']);
        $fields['featured_image'] = $request->file('featured_image')->store('public/products');

        $product = Product::create($fields);
        $product->update(['slug' => \Illuminate\Support\Str::slug($product->name . ' ' . $product->id)]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('moderator.products.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $record_id
     * @return Response
     */
    public function update(Request $request, int $record_id)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:1000',
            'featured_image' => 'nullable|file|image',
            'category_id' => 'required|numeric|exists:product_categories,id',
        ]);

        $record = Product::findOrFail($record_id);

        $fields = $request->only(['name', 'description', 'category_id']);
        $fields['slug'] = \Illuminate\Support\Str::slug($record->name . ' ' . $record->id);
        if($request->hasFile('featured_image'))
            $fields['featured_image'] = $request->file('featured_image')->store('public/products');

        $record->update($fields);

        flash('Successfully modified the record!')->success();
        return redirect()->route('moderator.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return Response
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = Product::findOrFail($record_id);
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('moderator.products.index');
    }
}