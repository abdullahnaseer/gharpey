@extends('buyer.layouts.dashboard.dashboard')

@section('styles')
    <style>
        @media screen and (max-width: 786px) {
            .table tr {
                display: flex;
                flex-direction: column;
                justify-items: center;
                margin: auto 0;
                align-content: center;
            }
        }
    </style>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Account Wishlist</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h2>My Orders</h2>

    <div class="mb-4"></div>
    <!-- margin -->

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
                            <h2 class="product-title ">
                                <a href="{{route('buyer.products.show', [$product->slug])}}">
                                    {{$product->name}} </a>
                            </h2>

                            <div class="price-box  m-b-5">
                                <span class="product-price">Rs. {{$product->price}}</span>
                            </div>
                            <p class="product-location text-center m-b-5">
                                <img src="/assets1/images/svg/shop/shop.svg" class="mr-2 d-inline-block" width="15" alt="">

                                <a href="{{route('buyer.shop.show', [$product->seller->shop_slug])}}">{{$product->seller->shop_name}}</a>
                            </p>

                            <!-- End .price-box -->

                            {{--                                        <p class="product-location mr-5 text-right">--}}
                            {{--                                            <img src="assets/images/svg/shop/map-pin.svg" width="15" alt="">--}}
                            {{--                                            <a href="#">Islamabad</a>--}}
                            {{--                                        </p>--}}

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
    @else
        <div class="alert alert-info">
            No items found in your wishlist. <a href="{{route('buyer.products.index')}}">Continue Shopping!</a>
        </div>
    @endif
@endsection
