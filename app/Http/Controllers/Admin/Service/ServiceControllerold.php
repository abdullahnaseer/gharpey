<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceQuestion;
use App\Models\ServiceQuestionChoices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

class ServiceController extends Controller
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
        $records = Service::with([])->get();
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.index', ['categories' => $categories]);
    }

    /**
     * Display create page of the resource.
     *
     * @return mixed
     */
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', ['categories' => $categories]);
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
            'name' => 'required|min:3|max:100',
            'description' => 'max:25000',
            'category_id' => 'required|exists:product_categories,id',
            'featured_image' => 'required|file|image',
        ]);

        $fields = $request->only(['name', 'description', 'category_id']);
        $fields['featured_image'] = $request->file('featured_image')->store('public/services');

        $service = Service::create($fields);
        $service->update(['slug' => \Illuminate\Support\Str::slug($service->name . ' ' . $service->id)]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.services.index');
    }

    /**
     * Display edit page of the resource.
     *
     * @return Factory|View
     */
    public function edit($service_id)
    {
        $service = Service::with(['category', 'questions', 'questions.choices'])->findOrFail($service_id);
        $categories = ServiceCategory::all();
        return view('admin.services.edit', ['service' => $service, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $record_id
     * @return mixed
     */
    public function update(Request $request, int $record_id)
    {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'description' => 'max:25000',
            'category_id' => 'required|exists:product_categories,id',
            'featured_image' => 'file|image',
        ]);

        $record = Service::findOrFail($record_id);

        $fields = $request->only(['name', 'description', 'category_id']);
        $fields['slug'] = \Illuminate\Support\Str::slug($record->name . ' ' . $record->id);
        if ($request->hasFile('featured_image'))
            $fields['featured_image'] = $request->file('featured_image')->store('public/services');

        $record->update($fields);
        $record->update(['slug' => \Illuminate\Support\Str::slug($record->name . ' ' . $record->id)]);

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return mixed
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = Service::findOrFail($record_id);
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.services.index');
    }
}
