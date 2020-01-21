<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Return the logged in user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 200,
                'message' => 'Successfully Logged In',
                'data' => ['user' => $request->user()]
            ], 200);
    }
}
