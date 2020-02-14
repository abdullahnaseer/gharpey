@extends('buyer.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="home-slider owl-carousel owl-carousel-lazy owl-theme owl-theme-light">
                    <div class="home-slide">
                        <div class="owl-lazy slide-bg" data-src="assets1/images/slider/slide-1.jpg"></div>
                        <div class="home-slide-content text-white">
                            <h3>Get up to <span>60%</span> off</h3>
                            <h1>Summer Sale</h1>
                            <p>Limited items available at this price.</p>
                            <a href="category.html" class="btn btn-dark">Book A Service</a>
                        </div>
                        <!-- End .home-slide-content -->
                    </div>
                    <!-- End .home-slide -->

                    <div class="home-slide">
                        <div class="owl-lazy slide-bg" data-src="assets1/images/slider/slide-2.jpg"></div>
                        <div class="home-slide-content">
                            <h3>OVER <span>200+</span></h3>
                            <h1>GREAT DEALS</h1>
                            <p>While they last!</p>
                            <a href="category.html" class="btn btn-dark">Book A Service</a>
                        </div>
                        <!-- End .home-slide-content -->
                    </div>
                    <!-- End .home-slide -->

                    <div class="home-slide">
                        <div class="owl-lazy slide-bg" data-src="assets1/images/slider/slide-3.jpg"></div>
                        <div class="home-slide-content">
                            <h3>up to <span>40%</span> off</h3>
                            <h1>NEW ARRIVALS</h1>
                            <p>Starting at $9</p>
                            <a href="category.html" class="btn btn-dark">Book A Service</a>
                        </div>
                        <!-- End .home-slide-content -->
                    </div>
                    <!-- End .home-slide -->
                </div>
                <!-- End .home-slider -->

                <div class="mb-6"></div>
                <!-- margin -->

                @foreach($categories as $category)
                    <h2 class="carousel-title">{{$category->name}}</h2>

                    <div class="home-featured-products owl-carousel owl-theme owl-dots-top">
                        @foreach($category->services as $service)
                            <div class="product">
                                <figure class="product-image-container">
                                    <a href="{{route('buyer.services.show', $service->slug)}}" class="product-image">
                                        <img src="{{ str_replace('public', '/storage', $service->featured_image) }}" alt="product">
                                    </a>
{{--                                    <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
                                </figure>
                                <div class="product-details">
                                    <!-- End .product-container -->
                                    <h2 class="product-title">
                                        <a href="product.html">{{ $service->name }}</a>
                                    </h2>

                                    <!-- End .product-action -->
                                </div>
                                <!-- End .product-details -->
                            </div>
                        @endforeach
                    </div>
                    <!-- End .featured-proucts -->

                    <div class="mb-3"></div>
                @endforeach

                <div class="mb-6"></div>
                <!-- margin -->

                <div class="mb-3"></div>
                <!-- margin -->

                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="feature-box feature-box-simple text-center">
                            <i class="icon-star"></i>

                            <div class="feature-box-content">
                                <h3>Dedicated Service</h3>
                                <p>Consult our specialists for help with an order, customization, or design advice</p>
                                <a href="#" class="btn btn-outline-dark">Get in touch</a>
                            </div>
                            <!-- End .feature-box-content -->
                        </div>
                        <!-- End .feature-box -->
                    </div>
                    <!-- End .col-md-4 -->

                    <div class="col-sm-6 col-md-4">
                        <div class="feature-box feature-box-simple text-center">
                            <i class="icon-reply"></i>

                            <div class="feature-box-content">
                                <h3>Free Returns</h3>
                                <p>We stand behind our goods and services and want you to be satisfied with them.</p>
                                <a href="#" class="btn btn-outline-dark">Return Policy</a>
                            </div>
                            <!-- End .feature-box-content -->
                        </div>
                        <!-- End .feature-box -->
                    </div>
                    <!-- End .col-md-4 -->

                    <div class="col-sm-6 col-md-4">
                        <div class="feature-box feature-box-simple text-center">
                            <i class="icon-paper-plane"></i>

                            <div class="feature-box-content">
                                <h3> Shipping</h3>
                                <p>Currently over 50 countries qualify for express international shipping.</p>
                                <a href="#" class="btn btn-outline-dark">Lear More</a>
                            </div>
                            <!-- End .feature-box-content -->
                        </div>
                        <!-- End .feature-box -->
                    </div>
                    <!-- End .col-md-4 -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .col-lg-9 -->

        </div>
        <!-- End .row -->
    </div>
@endsection
