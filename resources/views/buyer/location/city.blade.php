@php
    $seo_title =  "Find a local professional in {$city->city}, {$city->state_code} | Serviced By ONE"
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
                    <div class="one-title-5 one-margin-bottom--double">Popular services in {{$city->city}}
                        , {{$city->state_code}}.
                    </div>
                </div><!-- .col-8 -->

                @if($services->count())
                    @foreach($services as $service)
                        <div class="col-lg-3 col-sm-6 services-item">
                            <div class="card h-100">
                                <a href="{{url($state.'/'.$city->slug.'/'.$service->slug)}}">
                                    <img class="card-img-top"
                                         src="{{ asset(str_replace("public","storage", $service->resized_featured_image)) }}"
                                         alt="">
                                </a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="{{url($state.'/'.$city->slug.'/'.$service->slug)}}">{{$service->name}}</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger">No Services Found for this area.</div>
                @endif
            </div>


            <div class="clearfix mb-5"></div>
        </div>
    </section>
@endsection
