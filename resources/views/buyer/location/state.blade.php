@php
    $seo_title =  "Find a local professional in {$state->state} | Serviced By ONE";
@endphp

@extends('buyer.layouts.app')

@section('content')
    <section class="bg-primary section-80">
        <div class="container text-left">
            <div class="row">
                <div class="col-lg-8 col-md-10 col-sm-12 header-line">
                    <h1 class="header-title-1 tp-margin-bottom--quad">Find local professionals that can service your
                        needs.</h1>
                    {{--<p class="lead">A landing page template freshly redesigned for Bootstrap 4</p>--}}
                </div><!-- .col-8 -->
            </div><!-- .row -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="one-title-5 one-margin-bottom--double">Popular services in {{$state->state}}.</div>
                </div><!-- .col-8 -->

                @if($agent->isMobile())
                    <div class="scrolling-wrapper services-item services-item-scroll">
                        @foreach($services as $service)
                            {{--<div class="col-sm-4 col-md-3 services-item mb-4">--}}
                            <div class="card h-100">
                                @php($url = 'services/'.$service->slug)
                                <a href="{{url($url)}}">
                                    <img class="card-img-top"
                                         src="{{ asset(str_replace("public","storage", $service->resized_featured_image)) }}"
                                         alt="" onerror="this.src='{{url('/default.png')}}'">
                                </a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a class="one-color--black-300" href="{{url($url)}}">{{ $service->name }}</a>
                                    </h4>
                                </div>
                            </div>
                            {{--</div>--}}
                        @endforeach
                    </div>
                @else

                    @foreach($services as $service)
                        <div class="col-sm-4 col-md-3 services-item mb-4">
                            <div class="card h-100">
                                @php($url = 'services/'.$service->slug)
                                <a href="{{url($url)}}">
                                    <img class="card-img-top"
                                         src="{{ asset(str_replace("public","storage", $service->resized_featured_image)) }}"
                                         alt="" onerror="this.src='{{url('/default.png')}}'">
                                </a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="{{url($url)}}">{{ $service->name }}</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @endif
            </div>


            {{--<div class="row">--}}
            {{--<div class="col-lg-12">--}}
            {{--<div class="one-title-5 one-margin-bottom--double">Popular services in {{$state->state}}.</div>--}}
            {{--</div><!-- .col-8 -->--}}

            {{--@if($services->count())--}}
            {{--@if($agent->isMobile())--}}
            {{--<div class="scrolling-wrapper">--}}
            {{--@foreach($services as $service)--}}
            {{--<div class="col-sm-4 col-md-3 services-item mb-4">--}}
            {{--<div class="card h-100">--}}
            {{--<a href="{{url('services/'.$service->slug)}}">--}}
            {{--<img class="card-img-top" src="{{ asset(str_replace("public","storage", $service->featured_image)) }}" alt="" onerror="this.src='{{url('/default.png')}}'">--}}
            {{--</a>--}}
            {{--<div class="card-body">--}}
            {{--<h4 class="card-title">--}}
            {{--<a class="one-color--black-300" href="{{url('services/'.$service->slug)}}">{{ $service->name }}</a>--}}
            {{--</h4>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endforeach--}}
            {{--</div>--}}
            {{--@else--}}
            {{--<div class="row">--}}
            {{--@foreach($services as $service)--}}
            {{--<div class="col-sm-4 col-md-3 services-item mb-4">--}}
            {{--<div class="card h-100">--}}
            {{--<a href="{{url('services/'.$service->slug)}}">--}}
            {{--<img class="card-img-top" src="{{ asset(str_replace("public","storage", $service->featured_image)) }}" alt="" onerror="this.src='{{url('/default.png')}}'">--}}
            {{--</a>--}}
            {{--<div class="card-body">--}}
            {{--<h4 class="card-title">--}}
            {{--<a href="{{url('services/'.$service->slug)}}">{{ $service->name }}</a>--}}
            {{--</h4>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endforeach--}}
            {{--</div>--}}
            {{--@endif--}}
            {{----}}
            {{--@foreach($services as $service)--}}
            {{--<div class="col-lg-3 col-sm-6 services-item">--}}
            {{--<div class="card h-100">--}}
            {{--<a href="{{url('services/'.$service->slug)}}">--}}
            {{--<img class="card-img-top" src="{{ asset(str_replace("public","storage", $service->featured_image)) }}" alt="">--}}
            {{--</a>--}}
            {{--<div class="card-body">--}}
            {{--<h4 class="card-title">--}}
            {{--<a href="{{url('services/'.$service->slug)}}">{{$service->name}}</a>--}}
            {{--</h4>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endforeach--}}
            {{--@else--}}
            {{--<div class="alert alert-danger">No Services Found for this area.</div>--}}
            {{--@endif--}}
            {{--</div>--}}

            <div class="clearfix mb-5"></div>
        </div>
    </section>

    <section id="how">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <img src="https://servicedbyone.com/images/us.png"
                         style="width: 400px;margin-bottom: 25px;max-width: 100%;box-shadow: 0 0 5px 0 rgba(204, 204, 204, 0.75);padding: 10px;background: #fff;">
                </div>
                <div class="col-lg-8 mx-auto col-md-12">
                    <h2>Popular Cities in {{$state->state}}</h2>
                    <p class="leadtext">From big cities to small towns, we’ve got professionals on call covering every
                        county in the U.S, From the smallest job to the toughest we've got it covered.</p>
                </div>
                <div class="col-lg-12 mx-auto">

                    <ol class="states-list__list">
                        @foreach($state->cities as $city)
                            <li>
                                <a class="one-link--dark one-color--black-300"
                                   href="{{url($state->state_code.'/'.$city->slug)}}">{{$city->city}}
                                    , {{$city->state_code}}</a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection
