<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Moderator;
use App\Models\Buyer;
use App\Models\City;
use App\Notifications\NewUser\NewModeratorNotification;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Str;

class ModeratorController extends Controller
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
     * @return Response
     */
    public function json()
    {
        $records = Moderator::with(['location', 'location.city'])->get();
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
        return view('admin.users.moderators.index', ['cities' => $cities]);
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
            'email' => 'required|email|unique:moderators,email',
            'phone' => ['required', new Phone()],
            'address' => 'required|min:3|max:255',
            'location_id' => 'required|numeric|exists:city_areas,id',
        ]);

        $password = Str::random(8);
        $fields = $request->only(['name', 'email', 'phone', 'address', 'location_id']);
        $fields['password'] = Hash::make($password);

        $user = Moderator::create($fields);
        $user->notify(new NewModeratorNotification($fields['email'], $password));

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.users.moderators.index');
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
            'email' => 'required|email|unique:moderators,email,' . $record_id,
            'phone' => ['required', new Phone()],
            'address' => 'required|min:3|max:255',
            'location_id' => 'required|numeric|exists:city_areas,id',
        ]);

        $record = Moderator::findOrFail($record_id);
        $record->update($request->only(['name', 'email', 'phone', 'address', 'location_id']));

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.users.moderators.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return Response
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = Moderator::findOrFail($record_id);
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.users.moderators.index');
    }
}
