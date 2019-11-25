<?php

namespace App\Http\Controllers\Admin\Location;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\CityArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
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
     * @param  \App\Models\Country $country
     * @param  \App\Models\State $state
     * @param  \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function index(Country $country, State $state, City $city)
    {
        $records = $city->areas()->paginate(25);
        return view('admin.location.areas.index', ['records' => $records, 'country' => $country, 'state' => $state, 'city' => $city]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country $country
     * @param  \App\Models\State $state
     * @param  \App\Models\City $city
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Country $country, State $state, City $city)
    {
        $request->validate([
            'name' => 'required|unique:city_areas,name,null,null,city_id,'.$city->id.'|min:3'
        ]);

        $area = $city->areas()->create(['name' => $request->input('name')]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.location.countries.states.cities.areas.index', [$country->id, $state->id, $city->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country $country
     * @param  \App\Models\State $state
     * @param  \App\Models\City $city
     * @param  \App\Models\CityArea $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country, State $state, City $city, CityArea $area)
    {
        $request->validate([
            'name' => 'required|unique:city_areas,name,null,null,city_id,'.$city->id.'|min:3'
        ]);

        $area->name = $request->name;
        $area->save();

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.location.countries.states.cities.areas.index', [$country->id, $state->id, $city->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country $country
     * @param  \App\Models\State $state
     * @param  \App\Models\City $city
     * @param  \App\Models\CityArea $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country, State $state, City $city, CityArea $area)
    {
        $area->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.location.countries.states.cities.areas.index', [$country->id, $state->id, $city->id]);
    }
}
