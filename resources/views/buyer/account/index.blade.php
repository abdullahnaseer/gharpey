@extends('buyer.layouts.dashboard.dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Account</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h2>My Dashboard</h2>

    <div class="mb-4"></div>
    <!-- margin -->

    <h3>Account Information</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Contact Information
                    <a href="{{route('buyer.account.getInfo')}}" class="card-edit">Edit</a>
                </div>
                <!-- End .card-header -->

                <div class="card-body">
                    <p>
                        {{$user->name}}<br> {{$user->email}}
                        <br>
                        <a href="{{route('buyer.account.getPassword')}}">Change Password</a>
                    </p>
                </div>
                <!-- End .card-body -->
            </div>
            <!-- End .card -->
        </div>
        <!-- End .col-md-6 -->

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Address Book
                    <a href="{{route('buyer.account.getAddress')}}" class="card-edit">Edit</a>
                </div>

                <div class="card-body">
                    <h4 class="">Default Address</h4>
                    <address>
                        @if(!is_null($user->address) && !is_null($user->location_id))
                            {{$user->address}}<br>
                            {{$user->location->name}}, {{$user->location->city->name}}<br>
                            {{$user->location->city->state->name}}, {{$user->location->city->state->country->name}}<br>
                        @else
                            You have not set a default address.<br>
                        @endif
                    </address>
                </div>
                <!-- End .card-body -->
            </div>
            <!-- End .card -->
        </div>
        <!-- End .col-md-6 -->
    </div>
@endsection
