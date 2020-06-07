<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Rules\Phone;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PhoneVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:seller');
        $this->middleware('seller.verified_email');

        $this->middleware('seller.input_phone')->except(['input', 'store']);
    }

    /**
     * Show the phone form.
     *
     * @param Request $request
     * @return mixed
     */
    public function input(Request $request)
    {
        return $request->user('seller')->hasVerifiedPhone()
            ? redirect()->route('home')
            : view('seller.auth.input_phone');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => ['required', new Phone()]
        ]);

        $user = $request->user('seller');
        $user->update($validatedData);

        $request->user('seller')->sendPhoneVerificationNotification();

        return redirect()->route('seller.phone_verification.notice')->with('status', 'Your phone was added successfully!');
    }

    public function show(Request $request)
    {
        return $request->user('seller')->hasVerifiedPhone()
            ? redirect()->route('seller.dashboard')
            : view('seller.auth.verify_phone');
    }

    /**
     * Mark the authenticated user's phone as verified.
     *
     * @param Request $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        if ($request->user('seller')->verification_code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => ['The code your provided is wrong. Please try again or request another call.'],
            ]);
        }

        if ($request->user('seller')->hasVerifiedPhone()) {
            return redirect()->route('seller.dashboard');
        }

        $request->user('seller')->markPhoneAsVerified();

        return redirect()->route('seller.dashboard')->with('status', 'Your phone was successfully verified!');
    }

    /**
     * Resend the phone verification notification.
     *
     * @param Request $request
     * @return mixed
     */
    public function resend(Request $request)
    {
        if ($request->user('seller')->hasVerifiedPhone()) {
            return redirect()->route('seller.dashboard');
        }

        $request->user('seller')->sendPhoneVerificationNotification();

        return back()->with('status', "A fresh code is sent on your phone.");
    }
}
