<?php

namespace App\Http\Controllers\Admin\Location;

use App\DataTables\StatesDataTable;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index(Country $country)
    {
        $records = $country->states()->paginate(25);
        return view('admin.location.states.index', ['records' => $records, 'country' => $country]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|unique:states,name,null,null,country_id,'.$country->id.'|min:3'
        ]);

        $state = $country->states()->create(['name' => $request->input('name')]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.location.countries.states.index', [$country->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country $country
     * @param  \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country, State $state)
    {
        $request->validate([
            'name' => 'required|unique:states,name,null,null,country_id,'.$country->id.'|min:3'
        ]);

        $state->name = $request->name;
        $state->save();

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.location.countries.states.index', [$country->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country $country
     * @param  \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country, State $state)
    {
        $state->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.location.countries.states.index', [$country->id]);
    }
}
