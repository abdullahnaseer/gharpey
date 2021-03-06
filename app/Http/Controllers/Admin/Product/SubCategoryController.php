<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
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
     * @return mixed
     */
    public function json($category_id)
    {
        $category = ProductCategory::findOrFail($category_id);
        return $category->child_categories()->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @param $category_id
     * @return mixed
     */
    public function index($category_id)
    {
        $category = ProductCategory::with('parent_category')->findOrFail($category_id);
        $parent_categories = ProductCategory::parent_categories($category);

        return view('admin.products.subcategories.index', [
            'category' => $category,
            'parent_categories' => $parent_categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $category_id
     * @return mixed
     */
    public function store(Request $request, $category_id)
    {
        $category = ProductCategory::findOrFail($category_id);

        $request->validate([
            'name' => 'required|min:3|max:25',
            'featured_image' => 'required|file|image',
        ]);

        if ($category->depth <= 1) {
            $record = $category->child_categories()->create([
                'name' => $request->input('name'),
                'featured_image' => (
                $request->hasFile('featured_image')
                    ? $request->file('featured_image')->store('public/productcategories')
                    : null),
                'depth' => $category->depth + 1
            ]);
            $record->update(['slug' => Str::slug($record->name . ' ' . $record->id)]);

            flash('Successfully created the new record!')->success();
        } else {
            flash()->error("Sub categories upto this level/depth are not allowed!!!");
        }

        return redirect()->route('admin.products.categories.subcategories.index', [$category_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $category_id
     * @param $record_id
     * @return mixed
     */
    public function update(Request $request, $category_id, $record_id)
    {
        $category = ProductCategory::findOrFail($category_id);

        $request->validate([
            'name' => 'required|min:3|max:255',
            'featured_image' => 'nullable|file|image',
        ]);

        $record = $category->child_categories()->findOrFail($record_id);
        $fields = [
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name') . ' ' . $record->id),
            'depth' => $category->depth + 1
        ];
        if ($request->hasFile('featured_image'))
            $fields['featured_image'] = $request->file('featured_image')->store('public/productcategories');
        $record->update($fields);

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.products.categories.subcategories.index', [$category_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $category_id
     * @param $record_id
     * @return mixed
     */
    public function destroy(Request $request, $category_id, $record_id)
    {
        $category = ProductCategory::findOrFail($record_id);

        if ($category->child_categories()->count() > 0)
        {
            flash('Cannot Delete a category with active child categories!!!')->error();
        } else if ($category->products()->withTrashed()->count() > 0)
        {
            flash('Cannot Delete a category with products!!!')->error();
        } else {
            $category->delete();
            flash('Successfully deleted the record!')->success();
        }

        return redirect()->route('admin.products.categories.subcategories.index', [$category_id]);
    }
}
