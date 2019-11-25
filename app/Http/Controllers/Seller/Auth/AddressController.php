<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        dd($request->all());

        $validatedData = $request->validate([
            'phone' => ['required', new Phone()]
        ]);

        $user = $request->user('seller');
        $user->update($validatedData);

        $request->user('seller')->sendPhoneVerificationNotification();

        return redirect()->route('seller.phone_verification.notice')->with('status', 'Your phone was added successfully!');
    }
}
