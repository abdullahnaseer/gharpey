@extends('buyer.layouts.dashboard.dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{route('buyer.account.index')}}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Address</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h2>Edit Account Information</h2>
    <h3 class="mb-2">Change Address</h3>

    <form action="{{route('buyer.account.updateAddress')}}" method="POST">
        @csrf
        <div class="form-group required-field">
            <label for="acc-address">Address</label>
            <input type="text" class="form-control @error('area') is-invalid @enderror" id="acc-address" name="address"
                   value="{{old('address', $user->address)}}" required>
        </div>

        <div class="form-group required-field">
            <label for="acc-area">Area</label>
            <select class="form-control kt-select2 @error('area') is-invalid @enderror" id="area" name="area" required
                    style="width: 100%">
                @foreach($cities as $city)
                    @if($city->areas->count())
                        <optgroup label="{{$city->name}}">
                            @foreach($city->areas as $area)
                                <option value="{{$area->id}}"
                                        @if((int) old('area', $user->location_id) == $area->id) selected @endif>{{$area->name}}</option>
                            @endforeach
                        </optgroup>
                    @endif
                @endforeach
            </select>
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
