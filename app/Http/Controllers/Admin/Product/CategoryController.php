<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $records = ProductCategory::get();
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.products.categories.index');
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
            'featured_image' => 'required|file|image',
        ]);

        $record = ProductCategory::create([
            'name' => $request->input('name'),
            'featured_image' => ($request->hasFile('featured_image') ? $request->file('featured_image')->store('public/productcategories') : null)
        ]);
        $record->update(['slug' => \Illuminate\Support\Str::slug($record->name . ' ' . $record->id)]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.products.categories.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param App\Models\ProductCategory $record
     * @return Response
     */
    public function update(Request $request, $record_id)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'featured_image' => 'nullable|file|image',
        ]);

        $record = ProductCategory::findOrFail($record_id);
        $fields = [
            'name' => $request->input('name'),
            'slug' => \Illuminate\Support\Str::slug($request->input('name') . ' ' . $record->id)
        ];
        if($request->hasFile('featured_image'))
            $fields['featured_image'] = $request->file('featured_image')->store('public/productcategories');
        $record->update($fields);

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.products.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Spatie\Permission\Models\ProductCategory $record
     * @return Response
     */
    public function destroy(Request $request, $record_id)
    {
        ProductCategory::findOrFail($record_id)->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.products.categories.index');
    }
}
