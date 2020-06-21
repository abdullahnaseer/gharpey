@extends('buyer.layouts.app')

@section('styles')
    <style>
        .seller_image {
            width: 200px;
            height: 200px;
            margin: 20px auto;
            border-radius: 100%;
        }

        .table p {
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="sticky-wrapper mb-3" style="">
                    <div class="header-bottom sticky-header">
                        <div class="container">
                            <nav class="main-nav">
                                <ul class="menu sf-arrows sf-js-enabled" style="touch-action: pan-y;">
                                    <li class="@if(isset($products)) active @endif">
                                        <a href="{{route('buyer.shop.show', [$shop->shop_slug])}}">Products</a>
                                    </li>
                                    <li class="@if(isset($services)) active @endif">
                                        <a href="{{route('buyer.shop.show', [$shop->shop_slug, 'services' => 1])}}">Services</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div>
                    @if(isset($services))
                        @if($services->count())
                            <div class="row row-sm">
                                @foreach($services as $service)
                                    <div class="product product-list-wrapper">
                                        <figure class="product-image-container">
                                            <a href="#" class="product-image">
                                                <img src="{{ str_replace('public', '/storage', $service->pivot->featured_image) }}" alt="product">
                                            </a>
                                            {{--                        <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
                                        </figure>
                                        <div class="product-details">
                                            <h2 class="product-title">
                                                <a href="#">{{$service->name}}</a>
                                            </h2>
                                            <div class="ratings-container">
                                                <div class="product-ratings">
                                                    <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                                </div><!-- End .product-ratings -->
                                            </div><!-- End .product-container -->
                                            <div class="product-desc">
                                                <p>{{$service->pivot->description}}</p>
                                            </div><!-- End .product-desc -->
                                            <div class="price-box">
                                                <span class="product-price">Starting From RS. {{number_format($service->pivot->price, 0)}}</span>
                                            </div><!-- End .price-box -->

                                            <div>
                                                Available: {{$service->pivot->cities->pluck('name')->implode(", ")}}
                                            </div>

                                            <div class="product-action">
                                                {{--                                    <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
                                                {{--                                        <span>Add to Wishlist</span>--}}
                                                {{--                                    </a>--}}

                                                <a href="{{route('buyer.services.sellers.show', [$service->slug, $service->pivot->id, 'city_id' => isset($city) && $city ? $city->id : null])}}" class="paction add-cart" title="Order Now">
                                                    <span>Order Now</span>
                                                </a>
                                            </div><!-- End .product-action -->
                                        </div><!-- End .product-details -->
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">No Services found!!!</div>
                        @endif
                    @else
                        @if($products->count())
                            <div class="row row-sm">
                                @foreach($products as $product)
                                    <div class="col-6 col-md-4">
                                        <div class="product">
                                            <figure class="product-image-container">
                                                <a href="{{route('buyer.products.show', [$product->slug])}}" class="product-image">
                                                    <img src="{{str_replace("public","/storage",$product->featured_image)}}" alt="product">
                                                </a>
                                                {{--                                    <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
                                            </figure>
                                            <div class="product-details">
                                                <div class="ratings-container">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:{{$product->reviews_average * 20}}%"></span>
                                                        <!-- End .ratings -->
                                                    </div>
                                                    <!-- End .product-ratings -->
                                                    <a href="#" class="rating-link">( {{ $product->reviews_count }} Reviews )</a>
                                                </div>
                                                <!-- End .product-container -->
                                                <h2 class="product-title  m-b-5">
                                                    <a href="{{route('buyer.products.show', [$product->slug])}}">
                                                        {{$product->name}} </a>
                                                </h2>
                                                <div class="price-box  m-b-5">
                                                    <span class="product-price">Rs. {{$product->price}}</span>
                                                </div>
                                                <!-- End .price-box -->
                                                {{--                                    <p class="product-location float-left d-flex ml-5  m-b-5">--}}
                                                {{--                                        <img src="assets/images/svg/shop/shop.svg" class="mr-2 d-inline-block" width="15" alt="">--}}

                                                {{--                                        <a href="{{route('buyer.products.show', [$product->id])}}">{{$product->seller->name}}</a>--}}
                                                {{--                                    </p>--}}
                                                {{--                                    <p class="product-location mr-5 text-right">--}}
                                                {{--                                        <img src="assets/images/svg/shop/map-pin.svg" width="15" alt="">--}}
                                                {{--                                        <a href="#">Islamabad</a>--}}
                                                {{--                                    </p>--}}
                                                <div class="product-action ml-5">

                                                    @if(is_null($product->cart_item))
                                                        <a href="{{route('buyer.products.cart.create', [$product->id])}}" class="paction add-cart" title="Add to Cart">
                                                            <span>Add to Cart</span>
                                                        </a>
                                                    @else
                                                        <a href="{{route('buyer.products.cart.create', [$product->id, 'remove'])}}" class="paction add-cart" title="Add to Cart">
                                                            <span>Remove from Cart</span>
                                                        </a>
                                                    @endif

                                                    @if(auth()->check())
                                                        @php($condition = auth('buyer')->user()->hasWish($product->id))
                                                        <a href="{{route('buyer.products.wishlist.create', [$product->id])}}" class="paction add-wishlist" title="{{$condition ? "Remove from" : "Add to"}} Wishlist"
                                                           @if($condition) style="background-color: #9a2693;color: white;" @endif
                                                        >
                                                            <span>{{$condition ? "Remove from" : "Add to"}} Wishlist</span>
                                                        </a>
                                                    @endif
                                                </div>
                                                <!-- End .product-action -->
                                            </div>
                                            <!-- End .product-details -->
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{ $products->links() }}
                        @else
                            <div class="alert alert-info">No Products found!!!</div>
                        @endif
                    @endif
                </div>
            </div>
            <!-- End .col-lg-9 -->

            <aside class="sidebar-shop col-lg-4 order-lg-first">
                <div class="sidebar-wrapper">
                    <div class="widget">

                        <div id="widget-body-1  text-center">
                            <div class="widget-body">
                                <div class=""><img src="{{str_replace('public', '/storage', $shop->shop_image)}}" alt="" class=" seller_image img-responsive"></div>
                                <h4 class="seller_name text-center">
                                    {{$shop->shop_name}}
                                </h4>
{{--                                <h5 class="seller_description text-center">Description</h5>--}}
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td style="width:20px">
                                            <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <span class="glyphicon glyphicon-file"></span>From
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <p>{{$shop->business_location->city->name}}</p>
                                            <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:20px">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <span class="glyphicon glyphicon-file">Member Since</span>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            <p>{{$shop->created_at->toFormattedDateString()}}</p>
                                            <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->


                </div>
                <!-- End .sidebar-wrapper -->
            </aside>
            <!-- End .col-lg-3 -->
        </div>
        <!-- End .row -->
    </div>

    <div class="mb-5"></div>
@endsection

