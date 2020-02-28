@extends('buyer.layouts.dashboard.dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{route('buyer.account.index')}}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Password</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h3 class="mb-2">Change Password</h3>

    <form action="{{route('buyer.account.updatePassword')}}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group required-field">
                    <label for="acc-pass2">Password</label>
                    <input type="password" class="form-control" id="acc-pass2" name="password">
                </div>
                <!-- End .form-group -->
            </div>
            <!-- End .col-md-6 -->

            <div class="col-md-6">
                <div class="form-group required-field">
                    <label for="acc-pass3">Confirm Password</label>
                    <input type="password" class="form-control" id="acc-pass3" name="password_confirmation">
                </div>
                <!-- End .form-group -->
            </div>
            <!-- End .col-md-6 -->
        </div>
        <!-- End .row -->

        <div class="form-footer">
            <a href="{{route('buyer.account.index')}}"><i class="icon-angle-double-left"></i>Back</a>

            <div class="form-footer-right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        <!-- End .form-footer -->
    </form>
@endsection
