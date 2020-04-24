<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:seller');
        $this->middleware('seller.verified_email');
        $this->middleware('seller.verified_phone');
    }

    /**
     * Show the address form.
     *
     * @param Request $request
     * @return Response
     */
    public function input(Request $request)
    {
        $states = Country::first()->states()->with([
            'cities', 'cities.areas'
        ])->get();

        return $request->user('seller')->hasAddress()
            ? redirect()->route('seller.dashboard')
            : view('seller.auth.input_address', compact('states'));
    }

    public function store(Request $request)
    {
//        dd($request->all());

//        $warehouse_validation_rules = [
//            'warehouse_address' => 'required|min:5|max:255',
//            'warehouse_state' => 'exists:states,id',
//            'warehouse_city' => 'exists:cities,id',
//            'warehouse_area' => 'exists:city_areas,id',
//        ];
//        $business_validation_rules = [
//            'business_address' => 'required|min:5|max:255',
//            'business_state' => 'exists:states,id',
//            'business_city' => 'exists:cities,id',
//            'business_area' => 'exists:city_areas,id',
//        ];
//        $return_validation_rules = [
//            'return_address' => 'required|min:5|max:255',
//            'return_state' => 'exists:states,id',
//            'return_city' => 'exists:cities,id',
//            'return_area' => 'exists:city_areas,id',
//        ];

        $validatedData = $request->validate([
            'warehouse_address' => 'required|max:255',
            'warehouse_state' => 'exists:states,id',
            'warehouse_city' => 'exists:cities,id',
            'warehouse_area' => 'exists:city_areas,id',
            'business_address' => 'required_without:business_is_same|max:255',
            'business_state' => 'required_without:business_is_same|exists:states,id',
            'business_city' => 'required_without:business_is_same|exists:cities,id',
            'business_area' => 'required_without:business_is_same|exists:city_areas,id',
            'return_address' => 'required_without:return_is_same|max:255',
            'return_state' => 'required_without:return_is_same|exists:states,id',
            'return_city' => 'required_without:return_is_same|exists:cities,id',
            'return_area' => 'required_without:return_is_same|exists:city_areas,id',
        ]);


        $data = array();
        $data['warehouse_address'] = $request->input('warehouse_address');
        $data['warehouse_location_id'] = (int)$request->input('warehouse_area');
        $data['business_address'] = $request->has('business_is_same') ? $data['warehouse_address'] : (int)$request->input('business_address');
        $data['business_location_id'] = $request->has('business_is_same') ? $data['warehouse_location_id'] : (int)$request->input('business_area');
        $data['return_address'] = $request->has('return_is_same') ? $data['warehouse_address'] : $request->input('return_address');
        $data['return_location_id'] = $request->has('return_is_same') ? $data['warehouse_location_id'] : (int)$request->input('return_area');

        $user = $request->user('seller');
        $user->update($data);

        return redirect()->route('seller.approval')->with('status', 'Address settings updated successfully!');
    }
}
