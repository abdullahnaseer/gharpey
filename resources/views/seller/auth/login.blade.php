@extends('seller.layouts.app' )

@section('content')
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>Sign In</h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!--begin::Form-->
        <form class="kt-form" method="POST" action="{{ route('seller.login') }}" id="kt_login_form">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Email Address" name="email" autocomplete="off">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" placeholder="Password" name="password" autocomplete="off">
            </div>

            <!--begin::Action-->
            <div class="kt-login__actions">
                <a href="{{ route('seller.password.request') }}" class="kt-link kt-login__link-forgot">
                    Forgot Password ?
                </a>
                <button id="kt_login_signin_submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Sign In</button>
            </div>

            <!--end::Action-->
        </form>

        <!--end::Form-->

        <!--begin::Divider-->
    {{--                        <div class="kt-login__divider">--}}
    {{--                            <div class="kt-divider">--}}
    {{--                                <span></span>--}}
    {{--                                <span>OR</span>--}}
    {{--                                <span></span>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}

    <!--end::Divider-->

        <!--begin::Options-->
    {{--                        <div class="kt-login__options">--}}
    {{--                            <a href="#" class="btn btn-primary kt-btn">--}}
    {{--                                <i class="fab fa-facebook-f"></i>--}}
    {{--                                Facebook--}}
    {{--                            </a>--}}
    {{--                            <a href="#" class="btn btn-info kt-btn">--}}
    {{--                                <i class="fab fa-twitter"></i>--}}
    {{--                                Twitter--}}
    {{--                            </a>--}}
    {{--                            <a href="#" class="btn btn-danger kt-btn">--}}
    {{--                                <i class="fab fa-google"></i>--}}
    {{--                                Google--}}
    {{--                            </a>--}}
    {{--                        </div>--}}
    <!--end::Options-->
    </div>
@endsection
