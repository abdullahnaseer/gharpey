@extends('buyer.layouts.dashboard.dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{route('buyer.account.index')}}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Information</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h2>Edit Account Information</h2>

    <form action="{{route('buyer.account.updateInfo')}}" method="POST">
        @csrf
        <div class="form-group required-field">
            <label for="acc-name">Name</label>
            <input type="text" class="form-control" id="acc-name" name="name" value="{{old('name', $user->name)}}"
                   required>
        </div>

        <div class="form-group required-field">
            <label for="acc-email">Email</label>
            <input type="email" class="form-control" id="acc-email" name="email" value="{{old('email', $user->email)}}"
                   required>
        </div>

        <div class="form-group required-field">
            <label for="acc-phone">Phone</label>
            <input type="tel" class="form-control" id="acc-phone" name="phone" value="{{old('phone', $user->phone)}}"
                   required>
        </div>

        <div class="mb-2"></div>
        <!-- margin -->

        <div class="form-footer">
            <a href="{{route('buyer.account.index')}}"><i class="icon-angle-double-left"></i>Back</a>

            <div class="form-footer-right">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        <!-- End .form-footer -->
    </form>

@endsection
