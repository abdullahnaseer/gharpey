<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Rules\Phone;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Register the user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
            return response()->json(
                [
                    'status' => 422,
                    'message' => 'Validation Failed',
                    'errors' => $validator->errors()
                ], 422);

        event(new Registered($user = $this->create($request->all())));

        return response()->json(
            [
                'status' => 200,
                'message' => 'Successfully Logged In',
                'data' => ['user' => $user, 'token' => $user->createToken($request->device_name)->plainTextToken]
            ], 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:buyers'],
            'phone' => ['required', 'string', new Phone()],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    private function create(array $data)
    {
        return Buyer::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
