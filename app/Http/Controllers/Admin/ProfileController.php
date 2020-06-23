<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
        return view('admin.profile.overview');
    }

    public function change_password()
    {
        return view('admin.profile.change-password');
    }

    public function email_settings()
    {
        return view('admin.profile.email-settings');
    }

    public function personal()
    {
        return view('admin.profile.personal-info', [
            'cities' => City::with('areas')->get()
        ]);
    }

    public function update(Request $request)
    {
        $uri = $request->header()["referer"];
        $user = auth('admin')->user();

        if (strpos($uri[0], 'personal') == true) {
            $this->profile_validator($request->all())->validate();

            $fields = $request->only(['name', 'address', 'area', 'phone']);
            $fields['location_id'] = $fields['area'];
            if($request->hasFile('profile_avatar'))
                $fields['avatar'] = $request->file('profile_avatar')->store('public/admins');

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
            'address' => ['required', 'string', 'min:8'],
            'area' => ['required', 'integer', 'exists:city_areas,id'],
            'avatar' => ['file', 'image'],
        ]);
    }
}
