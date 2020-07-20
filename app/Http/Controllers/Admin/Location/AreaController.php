<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityArea;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Return a listing of the resource.
     *
     * @param int $country_id
     * @param int $state_id
     * @param int $city_id
     * @return mixed
     */
    public function json($country_id, $state_id, $city_id)
    {
        return CityArea::where('city_id', $city_id)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Country $country
     * @param State $state
     * @param City $city
     * @return mixed
     */
    public function index(Country $country, State $state, City $city)
    {
        $records = $city->areas()->paginate(25);
        return view('admin.location.areas.index', ['records' => $records, 'country' => $country, 'state' => $state, 'city' => $city]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @param State $state
     * @param City $city
     * @return mixed
     */
    public function store(Request $request, Country $country, State $state, City $city)
    {
        $request->validate([
            'name' => 'required|unique:city_areas,name,null,null,city_id,' . $city->id . '|min:3'
        ]);

        $area = $city->areas()->create(['name' => $request->input('name')]);

        flash('Successfully created the new Area!')->success();
        return redirect()->route('admin.location.countries.states.cities.areas.index', [$country->id, $state->id, $city->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @param State $state
     * @param City $city
     * @param CityArea $area
     * @return mixed
     */
    public function update(Request $request, Country $country, State $state, City $city, CityArea $area)
    {
        $request->validate([
            'name' => 'required|unique:city_areas,name,null,null,city_id,' . $city->id . '|min:3'
        ]);

        $area->name = $request->name;
        $area->save();

        flash('Successfully modified the Area!')->success();
        return redirect()->route('admin.location.countries.states.cities.areas.index', [$country->id, $state->id, $city->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country $country
     * @param State $state
     * @param City $city
     * @param CityArea $area
     * @return mixed
     */
    public function destroy(Request $request, Country $country, State $state, City $city, CityArea $area)
    {
        if(
            $area->seller_business_locations()->count()  > 0 ||
            $area->seller_warehouse_locations()->count() > 0 ||
            $area->seller_return_locations()->count()    > 0 ||
            $area->service_sellers()->count()            > 0 ||
            $area->product_orders()->count()             > 0 ||
            $area->buyers()->count()                     > 0
        ) {
            flash('Cannot Delete Area With Active Associated Records.')->error();
        } else {
            $area->delete();
            flash('Successfully deleted the Area!')->success();
        }

        return redirect()->route('admin.location.countries.states.cities.areas.index', [$country->id, $state->id, $city->id]);
    }
}
