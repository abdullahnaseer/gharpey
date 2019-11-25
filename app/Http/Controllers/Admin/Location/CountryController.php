<?php

namespace App\Http\Controllers\Admin\Location;

use App\DataTables\CountriesDataTable;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::paginate(25);
        return view('admin.location.countries.index', ['records' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:countries,name|min:3'
        ]);

        $country = Country::create(['name' => $request->input('name')]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.location.countries.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|unique:countries,name,'.$country->id.'|min:3'
        ]);

        $country->name = $request->name;
        $country->save();

        flash('Successfully modified the country!')->success();
        return redirect()->route('admin.location.countries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        $country->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.location.countries.index');
    }
}
