<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductTag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
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
    public function json()
    {
        return ProductTag::get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $records = ProductTag::paginate(25);
        return view('admin.products.tags.index', ['records' => $records]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_tags,name|min:3'
        ]);

        $record = ProductTag::create(['name' => $request->input('name')]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.products.tags.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \Spatie\Permission\Models\ProductTag $record
     * @return mixed
     */
    public function update(Request $request, $record_id)
    {
        $request->validate([
            'name' => 'required|unique:product_tags,name,' . $record_id . '|min:3'
        ]);
        $record = ProductTag::findOrFail($record_id);
        $record->name = $request->name;
        $record->save();

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.products.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Spatie\Permission\Models\ProductTag $record
     * @return mixed
     */
    public function destroy(Request $request, $record_id)
    {
        ProductTag::findOrFail($record_id)->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.products.tags.index');
    }
}
