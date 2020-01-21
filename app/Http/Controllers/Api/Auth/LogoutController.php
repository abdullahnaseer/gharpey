<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LogoutController extends Controller
{
    /**
     * Create a new login token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
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

        $user = $request->user();
        $user->tokens()->where('name', $request->input('device_name'))->each->delete();

        return response()->json(
            [
                'status' => 200,
                'message' => 'Successfully Logged Out',
                'data' => ['user' => $user]
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
            'device_name' => 'required'
        ]);
    }
}
