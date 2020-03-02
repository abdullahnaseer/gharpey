@extends('seller.layouts.app')

@section('content')
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>{{ __('Register') }}</h3>
        </div>

        <form class="kt-form" method="POST" action="{{ route('seller.register') }}">
            @csrf

            <div class="form-group">
                <input placeholder="Shop Name" id="shop_name" type="text" class="form-control @error('shop_name') is-invalid @enderror" name="shop_name" value="{{ old('shop_name') }}" required autocomplete="shop_name" autofocus>

                @error('shop_name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <hr>

            <div class="form-group">
                <input placeholder="Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input placeholder="Email Address" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="cnic" type="text" class="form-control @error('cnic') is-invalid @enderror" name="cnic" value="{{ old('cnic') }}" required autocomplete="cnic" placeholder="CNIC (_____-________-_)">

                @error('cnic')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="form-group">
                <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
            </div>

            <!--begin::Action-->
            <div class="kt-login__actions">

                <a href="{{ route('seller.login') }}" class="kt-link kt-login__link-forgot">
                    Already have account? Login
                </a>
                <button id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Register</button>
            </div>

            <div class="kt-login__actions">
                <a href="{{ route('seller.home') }}" class="kt-link kt-login__link-forgot">
                    Go to Homepage
                </a>
            </div>
        </form>
    </div>
@endsection
