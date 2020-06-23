<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\City;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function __construct()
    {

    }

    public function overview()
    {
        return view('seller.profile.overview');
    }

    public function change_password()
    {
        return view('seller.profile.change-password');
    }

    public function personal()
    {
        return view('seller.profile.personal-info');
    }

    public function update(Request $request)
    {
        $uri = $request->header()["referer"];
        $user = auth('seller')->user();

        if (strpos($uri[0], 'personal') == true) {
            $this->profile_validator($request->all())->validate();

            $fields = $request->only(['name', 'phone']);
            if($request->hasFile('profile_avatar'))
                $fields['avatar'] = $request->file('profile_avatar')->store('public/sellers');

            $user->update($fields);
            flash("Profile Updated successfully")->success();
            return redirect()->back();
        } else if (strpos($uri[0], 'pass') == true) {
            $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required', 'confirmed'],
            ]);

            if(Hash::check($request->input('current_password'), $user->getAuthPassword()))
            {
                $user->update(['password' => Hash::make($request->input('new_password'))]);
                flash("Password Updated successfully")->success();
                return redirect()->back();
            } else {
                throw ValidationException::withMessages(['current_password' => "Current Password not match in our system."]);
            }
        } else if (strpos($uri[0], 'setting') == true) {
            dd("YESSSSS");
        }

        return redirect()->back();
    }


    /**
     * Get a validator for an incoming profile update request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function profile_validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', new Phone()],
            'avatar' => ['file', 'image'],
        ]);
    }
}
