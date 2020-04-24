<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view('buyer.account.index', [
            'user' => auth()->user()
        ]);
    }

    public function getInfo(Request $request)
    {
        return view('buyer.account.settings.info', [
            'user' => auth()->user()
        ]);
    }

    public function updateInfo(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'unique:buyers,email,' . auth()->id()],
            'phone' => ['required', new Phone()],
        ]);

        if (auth()->user()->email != $request->input('email')) {
            $data['email_verified_at'] = null;
            auth()->user()->sendEmailVerificationNotification();

            flash()->success('Account Info has been update successfully. Make sure you verify your email.');
        } else {
            flash()->success('Account Info has been update successfully.');
        }

        auth()->user()->update($data);

        return redirect()->route('buyer.account.index');
    }

    public function getAddress(Request $request)
    {
        return view('buyer.account.settings.address', [
            'user' => auth()->user(),
            'cities' => City::with('areas')->get()
        ]);
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => ['required', 'string', 'min:8'],
            'area' => ['required', 'integer', 'exists:city_areas,id'],
        ]);

        auth()->user()->update([
            'address' => $request->input('address'),
            'location_id' => $request->input('area'),
        ]);

        flash()->success('Address is update successfully.');

        return redirect()->route('buyer.account.index');
    }

    public function getPassword(Request $request)
    {
        return view('buyer.account.settings.password', [
            'user' => auth()->user()
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->input('password'))
        ]);

        flash()->success('Password updated successfully');

        return redirect()->route('buyer.account.index');
    }
}
