<?php

namespace App\Http\Controllers\Admin\Location;

use App\DataTables\StatesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Return a listing of the resource.
     *
     * @param int $country_id
     * @return mixed
     */
    public function json($country_id)
    {
        return State::where('country_id', $country_id)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Country $country
     * @return mixed
     */
    public function index(Country $country)
    {
        $records = $country->states()->paginate(25);
        return view('admin.location.states.index', ['records' => $records, 'country' => $country]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @return mixed
     */
    public function store(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|unique:states,name,null,null,country_id,' . $country->id . '|min:3'
        ]);

        $state = $country->states()->create(['name' => $request->input('name')]);

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.location.countries.states.index', [$country->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @param State $state
     * @return mixed
     */
    public function update(Request $request, Country $country, State $state)
    {
        $request->validate([
            'name' => 'required|unique:states,name,null,null,country_id,' . $country->id . '|min:3'
        ]);

        $state->name = $request->name;
        $state->save();

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.location.countries.states.index', [$country->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country $country
     * @param State $state
     * @return mixed
     */
    public function destroy(Country $country, State $state)
    {
        if($state->areas()->count() > 0)
        {
            flash('Cannot Delete State With Cities.')->error();
        } else {
            $state->delete();
            flash('Successfully deleted the city!')->success();
        }

        return redirect()->route('admin.location.countries.states.index', [$country->id]);
    }
}
