<?php

namespace App\Http\Controllers\Moderator\User;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\City;
use App\Notifications\NewUser\NewBuyerNotification;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Str;

class BuyerController extends Controller
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
        $records = Buyer::with(['location', 'location.city'])->get();
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cities = City::with('areas')->get();
        return view('moderator.users.buyers.index', ['cities' => $cities]);
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:buyers,email',
            'phone' => ['required', new Phone()],
            'address' => 'required|min:3|max:255',
            'location_id' => 'required|numeric|exists:city_areas,id',
        ]);

        $password = Str::random(8);
        $fields = $request->only(['name', 'email', 'phone', 'address', 'location_id']);
        $fields['password'] = Hash::make($password);

        $user = Buyer::create($fields);
        $user->markEmailAsVerified();

        $user->notify(new NewBuyerNotification($fields['email'], $password));

        flash('Successfully created the new record!')->success();
        return redirect()->route('moderator.users.buyers.index');
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
            'name' => 'required|min:3',
            'email' => 'required|email|unique:buyers,email,' . $record_id,
            'phone' => ['required', new Phone()],
            'address' => 'required|min:3|max:255',
            'location_id' => 'required|numeric|exists:city_areas,id',
        ]);

        $record = Buyer::findOrFail($record_id);
        $record->update($request->only(['name', 'email', 'phone', 'address', 'location_id']));

        flash('Successfully modified the record!')->success();
        return redirect()->route('moderator.users.buyers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return Response
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = Buyer::findOrFail($record_id);
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('moderator.users.buyers.index');
    }
}
