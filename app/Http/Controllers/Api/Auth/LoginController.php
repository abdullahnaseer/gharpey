<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Create a new login token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 422,
                    'message' => 'Validation Failed',
                    'errors' => $validator->errors()
                ], 422);
        }

        $user = Buyer::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'status' => 422,
                    'message' => 'Incorrect Credentials',
                    'errors' => ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']])->errors()
                ], 422);
        }

        return response()->json(
            [
                'status' => 200,
                'message' => 'Successfully Logged In',
                'data' => ['user' => $user, 'token' => $user->createToken($request->device_name)->plainTextToken]
            ], 200);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);
    }
}
