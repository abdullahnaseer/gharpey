@extends('buyer.layouts.app', ['remove_top_margin' => true])

@section('styles')

@endsection

@section('content')
    <div class="jumbotron jumbotron-fluid"
         style="background: linear-gradient(rgba(0, 0, 0, 0.65) 35%, rgba(0, 0, 0, 0.8) 80%), url('{{ asset(str_replace("public","storage", $service->featured_image)) }}');
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
                                @foreach($cities as $city_i)
                                    <option value="{{$city_i->id}}" @if(app('request')->input('city_id') == $city_i->id) selected @endif>{{$city_i->name}}</option>
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

    @if(isset($service_sellers))
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{route('buyer.services.index')}}">Services</a></li>
                    <li class="breadcrumb-item"><a href="{{route('buyer.services.index')}}">{{$service->category->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$service->name}}</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger mb-5" id="errorsDiv">
                    <ul>
                        {{--                        @if ($errors->has('city_id'))--}}
                        {{--                            <li>The selected location is invalid or this service is not available for your location.</li>--}}
                        {{--                        @endif--}}
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success mb-5">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-9">
                    {{--                    <nav class="toolbox">--}}
                    {{--                        <div class="toolbox-left">--}}
                    {{--                            <div class="toolbox-item toolbox-sort">--}}
                    {{--                                <div class="select-custom">--}}
                    {{--                                    <select name="orderby" class="form-control">--}}
                    {{--                                        <option value="menu_order" selected="selected">Default sorting</option>--}}
                    {{--                                        <option value="popularity">Sort by popularity</option>--}}
                    {{--                                        <option value="rating">Sort by average rating</option>--}}
                    {{--                                        <option value="date">Sort by newness</option>--}}
                    {{--                                        <option value="price">Sort by price: low to high</option>--}}
                    {{--                                        <option value="price-desc">Sort by price: high to low</option>--}}
                    {{--                                    </select>--}}
                    {{--                                </div><!-- End .select-custom -->--}}

                    {{--                                <a href="#" class="sorter-btn" title="Set Ascending Direction"><span class="sr-only">Set Ascending Direction</span></a>--}}
                    {{--                            </div><!-- End .toolbox-item -->--}}
                    {{--                        </div><!-- End .toolbox-left -->--}}

                    {{--                        <div class="toolbox-item toolbox-show">--}}
                    {{--                            <label>Showing 1–9 of 60 results</label>--}}
                    {{--                        </div><!-- End .toolbox-item -->--}}

                    {{--    --}}{{--                    <div class="layout-modes">--}}
                    {{--    --}}{{--                        <a href="category.html" class="layout-btn btn-grid" title="Grid">--}}
                    {{--    --}}{{--                            <i class="icon-mode-grid"></i>--}}
                    {{--    --}}{{--                        </a>--}}
                    {{--    --}}{{--                        <a href="category-list.html" class="layout-btn btn-list active" title="List">--}}
                    {{--    --}}{{--                            <i class="icon-mode-list"></i>--}}
                    {{--    --}}{{--                        </a>--}}
                    {{--    --}}{{--                    </div><!-- End .layout-modes -->--}}
                    {{--                    </nav>--}}

                    @foreach($service_sellers as $service_seller)
                        <div class="product product-list-wrapper">
                            <figure class="product-image-container">
                                <a href="#" class="product-image">
                                    <img src="{{ str_replace('public', '/storage', $service_seller->featured_image) }}" alt="product">
                                </a>
                                {{--                        <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
                            </figure>
                            <div class="product-details">
                                <h2 class="product-title">
                                    <a href="#">{{$service_seller->seller->shop_name}}</a>
                                </h2>
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                    </div><!-- End .product-ratings -->
                                </div><!-- End .product-container -->
                                <div class="product-desc">
                                    <p>{{$service_seller->description}}</p>
                                </div><!-- End .product-desc -->
                                <div class="price-box">
                                    <span class="product-price">Starting From RS. {{number_format($service_seller->price, 0)}}</span>
                                </div><!-- End .price-box -->

                                <div class="product-action">
                                    {{--                                    <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
                                    {{--                                        <span>Add to Wishlist</span>--}}
                                    {{--                                    </a>--}}

{{--                                    <a href="#questionsModal" class="paction add-cart" title="Order Now" data-toggle="modal" data-target="#questionsModal" data-id="{{$service_seller->id}}">--}}
{{--                                        <span>Order Now</span>--}}
{{--                                    </a>--}}

                                    <a href="{{route('buyer.services.sellers.show', [$service->slug, $service_seller->id, 'city_id' => $city ? $city->id : null])}}" class="paction add-cart" title="Order Now">
                                        <span>Order Now</span>
                                    </a>
                                </div><!-- End .product-action -->
                            </div><!-- End .product-details -->
                        </div>
                    @endforeach

                    <nav class="toolbox toolbox-pagination">
                        <div class="toolbox-item toolbox-show">
                            <label>Showing 1–9 of 60 results</label>
                        </div><!-- End .toolbox-item -->

                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><span>...</span></li>
                            <li class="page-item"><a class="page-link" href="#">15</a></li>
                            <li class="page-item">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div><!-- End .col-lg-9 -->

                <aside class="sidebar-shop col-lg-3 order-lg-first">
                    <div class="sidebar-wrapper">
                        <div class="widget">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true" aria-controls="widget-body-1">{{$service->category->name}}</a>
                            </h3>

                            <div class="collapse show" id="widget-body-1">
                                <div class="widget-body">
                                    <ul class="cat-list">
                                        @foreach($service->category->services as $service_i)
                                            <li><a href="{{route('buyer.services.show', [$service_i->slug, 'city_id' => $city->id])}}" @if($service_i->id == $service->id) class="text-primary" @endif>{{$service_i->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <div class="widget">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Price</a>
                            </h3>

                            <div class="collapse show" id="widget-body-2">
                                <div class="widget-body">
                                    <form action="" method="GET">
                                        <div class="price-slider-wrapper">
                                            <div id="price-slider"></div><!-- End #price-slider -->
                                        </div><!-- End .price-slider-wrapper -->

                                        <div class="filter-price-action">
                                            <button type="submit" class="btn btn-primary">Filter</button>

                                            <div class="filter-price-text">
                                                <span id="filter-price-range"></span>
                                            </div><!-- End .filter-price-text -->
                                        </div><!-- End .filter-price-action -->
                                    </form>
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
    @endif
@endsection
