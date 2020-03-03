<?php

namespace App\Http\Controllers\Seller\Service;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Moderator;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSeller;
use App\Rules\Phone;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('auth:seller');
        $this->middleware('seller.approved');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $records = auth('seller')->user()->services()->with([])->get();
        foreach ($records as $record)
            $record->cities = ServiceSeller::find($record->pivot->id)->cities->implode("id", ",");
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('seller.services.index', [
            'services' => Service::whereNotIn('id',
                ServiceSeller::where('seller_id',
                    auth('seller')->id()
                )->get()->pluck('service_id')
            )->get(),
            'cities' => City::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id|unique:service_seller,service_id,NULL,id,seller_id,'.auth()->id(),
            'price' => 'required|numeric|min:100|max:20000',
            'description' => 'required|min:10|max:1000',
            'cities' => 'required|exists:cities,id',
            'featured_image' => 'required|file|image',
        ]);

        $fields = $request->only(['service_id', 'name', 'description', 'price']);
        $fields['featured_image'] = $request->file('featured_image')->store('public/services');
        $fields['seller_id'] = auth('seller')->id();

        $serviceSeller = ServiceSeller::create($fields);
        $serviceSeller->cities()->sync($request->input('cities'));

        flash('Successfully created the new record!')->success();
        return redirect()->route('seller.services.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $record_id
     * @return RedirectResponse
     */
    public function update(Request $request, int $record_id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id|unique:service_seller,service_id,'.$record_id.',service_id,seller_id,'.auth()->id(),
            'price' => 'required|numeric|min:100|max:20000',
            'description' => 'required|min:10|max:1000',
            'cities' => 'required|exists:cities,id',
            'featured_image' => 'required|file|image',
        ]);

        $record = ServiceSeller::where('seller_id', auth('seller')->id())
            ->where('service_id', $record_id)
            ->firstOrFail();

        $fields = $request->only(['service_id', 'name', 'description', 'price']);
        $fields['seller_id'] = auth('seller')->id();
        if($request->hasFile('featured_image'))
            $fields['featured_image'] = $request->file('featured_image')->store('public/services');

        $record->update($fields);
        $record->states()->sync($request->input('cities'));

        flash('Successfully modified the record!')->success();
        return redirect()->route('seller.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return RedirectResponse
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = ServiceSeller::where('seller_id', auth('seller')->id())
            ->where('service_id', $record_id)
            ->firstOrFail();
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('seller.services.index');
    }
}
