<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CKEditorController extends Controller
{
    /**
     * Upload image(s) for ckeditor and return their path(s).
     *
     * @param Request $request
     * @return mixed
     */
    public function upload(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => [
                        'message' => $validator->errors()->first()
                    ]
                ], 422);
        }

        $path = url(
            str_replace('public', 'storage',
                $request->file('upload')->store('public/users/' . auth()->id())
            )
        );

        return ["url" => $path];
    }

    /**
     * Get a validator for an uploading image file for ckeditor.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, ['upload' => [
            'required',
            'image',
            'max:5120' // Max 5 MB size
        ]]);
    }
}
