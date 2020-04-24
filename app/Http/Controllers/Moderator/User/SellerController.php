<?php

namespace App\Http\Controllers\Moderator\User;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Seller;
use App\Notifications\NewUser\NewSellerNotification;
use App\Notifications\SellerApproveNotification;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Str;

class SellerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin,moderator');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $records = Seller::with([
            'business_location',
            'business_location.city',
            'warehouse_location',
            'warehouse_location.city',
            'return_location',
            'return_location.city',
        ])->get();
        return $records;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $record_id
     * @return Response
     */
    public function approval(Request $request, int $record_id)
    {
        $user = Seller::findOrFail($record_id);
        $user->approveAccount();
        $user->notify(new SellerApproveNotification());

        flash('Account approved Successfully!')->success();
        return redirect()->route('moderator.users.sellers.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::with('areas')->get();
        return view('moderator.users.sellers.index', ['cities' => $cities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|min:3|max:40',
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:sellers,email',
            'cnic' => ['required', 'string', 'regex:/\d{5}-\d{7}-\d{1}/'],
            'phone' => ['required', new Phone()],
            'warehouse_address' => 'max:255',
            'warehouse_location_id' => 'exists:city_areas,id',
            'business_address' => 'max:255',
            'business_location_id' => 'exists:city_areas,id',
            'return_address' => 'max:255',
            'return_location_id' => 'exists:city_areas,id',
        ]);

        $slug = Str::slug($request->input('shop_name'));
        $check = Seller::where('shop_slug', $slug)->count();

        $password = Str::random(8);
        $fields = $request->all();
        $fields['shop_slug'] = $slug;
        $fields['password'] = Hash::make($password);

        $user = Seller::create($fields);
        $user->markPhoneAsVerified();
        $user->markEmailAsVerified();
        $user->approveAccount();

        if ($check)
            $user->update(['shop_slug' => $slug . '-' . $user->id]);

        $user->notify(new NewSellerNotification($fields['email'], $password));

        flash('Successfully created the new record!')->success();
        return redirect()->route('moderator.users.sellers.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $record_id
     * @return Response
     */
    public function update(Request $request, int $record_id)
    {
        $request->validate([
            'shop_name' => 'required|min:3|max:40',
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:sellers,email,' . $record_id,
            'cnic' => ['required', 'string', 'regex:/\d{5}-\d{7}-\d{1}/'],
            'phone' => ['required', new Phone()],
            'warehouse_address' => 'max:255',
            'warehouse_location_id' => 'exists:city_areas,id',
            'business_address' => 'max:255',
            'business_location_id' => 'exists:city_areas,id',
            'return_address' => 'max:255',
            'return_location_id' => 'exists:city_areas,id',
        ]);

        $record = Seller::findOrFail($record_id);

        $slug = Str::slug($request->input('shop_name'));
        $check = Seller::where('shop_slug', $slug)->where('id', '!=', $record_id)->count();
        $record->update($request->all());
        if ($check)
            $record->update(['shop_slug' => $slug . '-' . $record->id]);
        else
            $record->update(['shop_slug' => $slug]);

        flash('Successfully modified the record!')->success();
        return redirect()->route('moderator.users.sellers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return Response
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = Seller::findOrFail($record_id);
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('moderator.users.sellers.index');
    }
}
