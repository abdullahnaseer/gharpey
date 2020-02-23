@extends('buyer.layouts.app')

@section('styles')
    <style>
        @media screen and (max-width: 576px) {
            .m-padding-20 {
                padding-top: 40px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container py-4">
        <h2 class="m-padding-20">Thank You We Have Receive Your Request!</h2>
        <hr>
        <div>
            @if(auth('buyer')->user()->hasVerifiedEmail())
                <p>Please allow us a few hours to contact you with your personalized quote base on the information you
                    provided us. </p>
            @else
                <p>Please allow us a few hours to contact you with your personalized quote base on the information you
                    provided us. In the mean time we ask that you confirm your email so that you can sign in and view
                    your quote request details, the quote we provided, make payments online and more.</p>
                <p>An email has been sent to {{ auth()->user()->email }}, please click the link to confirm your email
                    and set your account password.</p>
            @endif
        </div>
    </div>
@endsection

@section('scripts')

@endsection
