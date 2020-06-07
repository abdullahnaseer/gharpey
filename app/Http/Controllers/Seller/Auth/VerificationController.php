<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/seller';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:seller');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    /**
     * Show the email verification notice.
     *
     * @param Request $request
     * @return mixed
     */
    public function show(Request $request)
    {
        return $request->user('seller')->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('seller.auth.verify');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route('seller.phone_verification.input');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param Request $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        if (!hash_equals((string)$request->route('id'), (string)$request->user('seller')->getKey())) {
            throw new AuthorizationException;
        }

        if (!hash_equals((string)$request->route('hash'), sha1($request->user('seller')->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user('seller')->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($request->user('seller')->markEmailAsVerified()) {
            event(new Verified($request->user('seller')));
        }

        return redirect($this->redirectPath())->with('status', "Email verified successfully");
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return mixed
     */
    public function resend(Request $request)
    {
        if ($request->user('seller')->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user('seller')->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
