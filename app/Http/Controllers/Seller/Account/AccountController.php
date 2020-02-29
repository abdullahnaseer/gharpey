<?php

namespace App\Http\Controllers\Seller\Account;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view('seller.account.index', [
            'user' => auth()->user()
        ]);
    }

    public function getShop(Request $request)
    {
        return view('seller.shop.settings', [
            'user' => auth()->user(),
            'cities' => City::with('areas')->get()
        ]);
    }

    public function updateShop(Request $request)
    {
        $data = $request->validate([
            'shop_image' => ['image', 'max:5000'],
            'shop_name' => ['required', 'string', 'max:40', 'min:5'],
            'warehouse_address' => 'required|max:255',
            'warehouse_area' => 'required|exists:city_areas,id',
            'business_address' => 'required|max:255',
            'business_area' => 'required|exists:city_areas,id',
            'return_address' => 'required|max:255',
            'return_area' => 'required|exists:city_areas,id',
        ]);

        $data['warehouse_location_id'] = $data['warehouse_area'];
        $data['business_location_id'] = $data['business_area'];
        $data['return_location_id'] = $data['return_area'];

        if($request->hasFile('shop_image'))
            $data['shop_image'] = $request->file('shop_image')->store('public/sellers');

        auth()->user()->update($data);
        flash()->success('Shop Settings has been update successfully.');
        return redirect()->route('seller.account.getShop');
    }

    public function getInfo(Request $request)
    {
        return view('seller.account.settings.info', [
            'user' => auth()->user()
        ]);
    }

    public function updateInfo(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'unique:sellers,email,'.auth()->id()],
            'phone' => ['required', new Phone()],
        ]);

        if(auth()->user()->email != $request->input('email'))
        {
            $data['email_verified_at'] = null;
            auth()->user()->sendEmailVerificationNotification();

            flash()->success('Account Info has been update successfully. Make sure you verify your email.');
        } else {
            flash()->success('Account Info has been update successfully.');
        }

        auth()->user()->update($data);

        return redirect()->route('seller.account.index');
    }

    public function getAddress(Request $request)
    {
        return view('seller.account.settings.address', [
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

        return redirect()->route('seller.account.index');
    }

    public function getPassword(Request $request)
    {
        return view('seller.account.settings.password', [
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

        return redirect()->route('seller.account.index');
    }
}
