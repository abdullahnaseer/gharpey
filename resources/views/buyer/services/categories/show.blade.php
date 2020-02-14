@php
    $seo_title =  "{$category->name} services | Serviced By ONE";
@endphp


@extends('buyer.layouts.app')

@section('content')
    <header class="bg-primary">
        <div class="container text-left">
            <div class="row">
                <div class="col-lg-8 col-md-10 col-sm-12 header-line">
                    <h1 class="header-title-1 tp-margin-bottom--quad">{{$category->name}}</h1>
                </div><!-- .col-8 -->
            </div><!-- .row -->

            <div class="row">
                @foreach($category->services as $service)
                    <div class="col-lg-3 col-sm-6 services-item mb-4">
                        <div class="card h-100">
                            @if(isset($location))
                                @php($url = $location->state_code.'/'.$location->slug.'/'.$service->slug)
                            @else
                                @php($url = 'services/'.$service->slug)
                            @endif
                            <a href="{{url($url)}}">
                                <img class="card-img-top"
                                     src="{{ asset(str_replace("public","storage", $service->resized_featured_image)) }}"
                                     alt="">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="{{url($url)}}">{{ $service->name }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="clearfix mt-5"></div>
            <a href="{{url()->previous() == url()->current() ? '/' :url()->previous()}}" class="btn btn-primary">Go
                Back</a>
        </div>
    </header>
@endsection
