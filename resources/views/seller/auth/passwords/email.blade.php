@extends('seller.layouts.app' )

@section('content')
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>Forgot Password</h3>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

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
        <form class="kt-form" method="POST" action="{{ route('seller.password.email') }}" id="kt_login_form">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Email Address" name="email" autocomplete="off">
            </div>

            <div class="kt-login__actions">
                <button id="kt_login_forgot_submit"
                        class="btn btn-brand btn-elevate kt-login__btn-primary">Submit
                </button>&nbsp;&nbsp;
                <a href="{{route('seller.login')}}" id="kt_login_forgot_cancel"
                   class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
