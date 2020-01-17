@extends('seller.layouts.app' )

@section('content')
    <div class="kt-login__form">
        <div class="kt-login__title">
            <h3>Account pending approval</h3>
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

        <div class="alert alert-info">Your account is pending approval. We will notify you when your account is approved.</div>

        <!--end::Form-->
    </div>
@endsection
