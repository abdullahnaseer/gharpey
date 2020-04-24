<?php


namespace App\Models\Traits;

trait UserApiTokenTrait
{

    /**
     * The api_token is used for ckeditor image upload.
     * All images uploaded by user will be uploaded against their account.
     *
     * @return void
     */
    public function setApiToken(): void
    {
        // api_token is used for ckeditor image upload.
        // All images uploaded by user will be uploaded against their account.

        // Better use a scheduled event to handle this
//        $user->tokens()->where('name', 'api_token')->delete();

        $this->update(['api_token' => $this->createToken('api_token')->plainTextToken]);
    }
}
