@extends('admin.layouts.app' )

@section('content')
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>Reset Password</h3>
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

        <form class="kt-form" method="POST" action="{{ route('admin.password.update') }}" id="kt_login_form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <input class="form-control" type="text" placeholder="Email Address" name="email" autocomplete="off">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" placeholder="Password" name="password" autocomplete="off">
            </div>
            <div class="form-group">
                <input id="password-confirm" type="password" placeholder="Confirm Password"
                       class="form-control" name="password_confirmation" required
                       autocomplete="new-password">
            </div>

            <div class="kt-login__actions">
                <button id="kt_login_forgot_submit"
                        class="btn btn-brand btn-elevate kt-login__btn-primary">Submit
                </button>&nbsp;&nbsp;
                <a href="{{route('admin.login')}}" id="kt_login_forgot_cancel"
                   class="btn btn-light btn-elevate kt-login__btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
