<?php

namespace App\Http\Controllers\Admin\Location;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
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
     * @return mixed
     */
    public function json($country_id, $state_id)
    {
        $records = City::where('state_id', $state_id)->get();
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Country $country
     * @param State $state
     * @return mixed
     */
    public function index(Country $country, State $state)
    {
        $records = $state->cities()->paginate(25);
        return view('admin.location.cities.index', ['records' => $records, 'country' => $country, 'state' => $state]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @param State $state
     * @return mixed
     */
    public function store(Request $request, Country $country, State $state)
    {
        $request->validate([
            'name' => 'required|unique:cities,name,null,null,state_id,' . $state->id . '|min:3'
        ]);

        $city = $state->cities()->create(['name' => $request->input('name')]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.location.countries.states.cities.index', [$country->id, $state->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @param State $state
     * @param City $city
     * @return mixed
     */
    public function update(Request $request, Country $country, State $state, City $city)
    {
        $request->validate([
            'name' => 'required|unique:cities,name,null,null,state_id,' . $state->id . '|min:3'
        ]);

        $city->name = $request->name;
        $city->save();

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.location.countries.states.cities.index', [$country->id, $state->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country $country
     * @param State $state
     * @param City $city
     * @return mixed
     */
    public function destroy(Request $request, Country $country, State $state, City $city)
    {
        $city->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.location.countries.states.cities.index', [$country->id, $state->id]);
    }
}
