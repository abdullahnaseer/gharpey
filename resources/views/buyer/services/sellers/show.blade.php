@extends('buyer.layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="jumbotron jumbotron-fluid"
         style="background: linear-gradient(rgba(0, 0, 0, 0.65) 35%, rgba(0, 0, 0, 0.8) 80%), url('{{ asset(str_replace("public","storage", $service_seller->featured_image)) }}');
                 background-repeat: no-repeat;
                 background-size: cover;
                 background-color: #f5f8fa;
                 color: #fff;
                 padding-top: 70px;
                 padding-bottom: 70px;">

        <div class="container margin-top-50">
            @unless(is_null($city))
                <h4 class="display-6 text-center m-padding-20 text-white">{{ $city->name }}, {{ $city->state->name }}</h4>
            @endunless

            <div class="col-lg-6 col-md-7 col-sm-9 mx-auto" style="background-color: rgb(255, 255, 255);color: #000;">
                <div class="p-sm-5 pt-5 pb-5">
                    <h3 class="display-6 text-center">Where do you need this service?</h3>

                    <form>
                        <div class="input-group">
                            <select class="form-control custom-select" name="city_id" id="city_id_input" aria-label="Select City" required="required">
                                <option selected disabled value="">Select City...</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" @if(app('request')->input('city_id') == $city->id) selected @endif>{{$city->name}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Proceed</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <input type="hidden" class="service-name" value="{{$service->name}}">

    @if(isset($service_seller))
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{route('buyer.services.index')}}">Services</a></li>
                    <li class="breadcrumb-item"><a href="{{route('buyer.services.index')}}">{{$service->category->name}}</a></li>
                    <li class="breadcrumb-item"><a href="{{route('buyer.services.show', $service->id)}}">{{$service->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$service_seller->seller->name}}</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger mb-5" id="errorsDiv">
                    <ul>
                        @if ($errors->has('city_id'))
                            <li>The selected location is invalid or this service is not available for your location.</li>
                        @endif
                    </ul>
                </div>
            @endif

            @if (app('request')->has('city_id') && !is_null($city))
                <div class="alert alert-danger mb-5">
                    <ul>
                        <li>The selected location is invalid or this service is not available for your location.</li>
                    </ul>
                </div>
            @else
                <div class="alert alert-info mb-5">
                    <ul>
                        <li>Select your city to proceed.</li>
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success mb-5">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <div class="mb-5"></div>
    @endif
@endsection

@section('scripts')

@endsection
