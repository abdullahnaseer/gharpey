@extends('buyer.layouts.app')

@section('content')
        <nav aria-label="breadcrumb" class="breadcrumb-nav mt-5">
            <div class="container">
                <ol class="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{route('buyer.products.index')}}">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                </ol>
            </div><!-- End .container -->
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-single-container product-single-default">
                        <div class="row">
                            <div class="col-lg-7 col-md-6 product-single-gallery">
                                <div class="product-slider-container product-item">
                                    <div class="product-single-carousel owl-carousel owl-theme">
                                        <div class="product-item">
                                            <img class="product-single-image" src="{{str_replace("public","/storage",$product->featured_image)}}" data-zoom-image="assets/images/products/zoom/product-1-big.jpg"/>
                                        </div>
{{--                                        <div class="product-item">--}}
{{--                                            <img class="product-single-image" src="assets/images/products/zoom/product-2.jpg" data-zoom-image="assets/images/products/zoom/product-2-big.jpg"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="product-item">--}}
{{--                                            <img class="product-single-image" src="assets/images/products/zoom/product-3.jpg" data-zoom-image="assets/images/products/zoom/product-3-big.jpg"/>--}}
{{--                                        </div>--}}
{{--                                        <div class="product-item">--}}
{{--                                            <img class="product-single-image" src="assets/images/products/zoom/product-4.jpg" data-zoom-image="assets/images/products/zoom/product-4-big.jpg"/>--}}
{{--                                        </div>--}}
                                    </div>
                                    <!-- End .product-single-carousel -->
                                    <span class="prod-full-screen">
                                            <i class="icon-plus"></i>
                                        </span>
                                </div>
                                <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                    <div class="col-3 owl-dot">
                                        <img src="{{str_replace("public","/storage",$product->featured_image)}}"/>
                                    </div>
{{--                                    <div class="col-3 owl-dot">--}}
{{--                                        <img src="assets/images/products/zoom/product-2.jpg"/>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-3 owl-dot">--}}
{{--                                        <img src="assets/images/products/zoom/product-3.jpg"/>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-3 owl-dot">--}}
{{--                                        <img src="assets/images/products/zoom/product-4.jpg"/>--}}
{{--                                    </div>--}}
                                </div>
                            </div><!-- End .col-lg-7 -->

                            <div class="col-lg-5 col-md-6">
                                <div class="product-single-details">
                                    <h1 class="product-title m-0 mb-1" style="line-height: normal;">{{$product->name}}</h1>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:{{$product->reviews_average * 20}}%"></span>
                                            <!-- End .ratings -->
                                        </div>
                                        <!-- End .product-ratings -->
                                        <a href="#" class="rating-link">( {{ $product->reviews_count }} Reviews )</a>
                                    </div>

                                    <div class="price-box">
{{--                                        <span class="old-price">$81.00</span>--}}
                                        <span class="product-price">Rs. {{$product->price}}</span>
                                    </div><!-- End .price-box -->

                                    <p class="product-location text-left m-b-5">
                                        <img src="/assets1/images/svg/shop/shop.svg" class="mr-2 d-inline-block" width="15" alt="">

                                        <a href="{{route('buyer.shop.show', [$product->seller->shop_slug])}}">{{$product->seller->shop_name}}</a>
                                    </p>

                                    <div class="product-desc">
                                        <p>{{\Str::limit($product->description, 100)}}</p>
                                    </div><!-- End .product-desc -->

{{--                                    <div class="product-filters-container">--}}
{{--                                        <div class="product-single-filter">--}}
{{--                                            <label>Colors:</label>--}}
{{--                                            <ul class="config-swatch-list">--}}
{{--                                                <li class="active">--}}
{{--                                                    <a href="#" style="background-color: #6085a5;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #ab6e6e;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #b19970;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #11426b;"></a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div><!-- End .product-single-filter -->--}}
{{--                                    </div><!-- End .product-filters-container -->--}}

                                    @if($product->inventory <= 0)
                                        <div class="alert alert-danger">This product is out of stock!</div>
                                    @endif
                                    <div class="product-action product-all-icons">
{{--                                        <div class="product-single-qty">--}}
{{--                                            <input class="horizontal-quantity form-control" type="text">--}}
{{--                                        </div><!-- End .product-single-qty -->--}}

                                        @if(is_null($cart_item))
                                            @if($product->inventory > 0)
                                                <a href="{{route('buyer.products.cart.create', [$product->id])}}" class="paction add-cart" title="Add to Cart">
                                                    <span>Add to Cart</span>
                                                </a>
                                            @endif
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
                                    </div><!-- End .product-action -->

                                    <div class="product-single-share">
                                        <label>Share:</label>
                                        <!-- www.addthis.com share plugin-->
                                        <div class="addthis_inline_share_toolbox"></div>
                                    </div><!-- End .product single-share -->
                                </div><!-- End .product-single-details -->
                            </div><!-- End .col-lg-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-single-container -->

                    <div class="product-single-tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-tab-qas" data-toggle="tab" href="#product-qas-content" role="tab" aria-controls="product-qas-content" aria-selected="false">Q&As</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                <div class="product-desc-content">
                                    <p>{{$product->description}}</p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- End .tab-pane -->

                            <div class="tab-pane fade" id="product-qas-content" role="tabpanel" aria-labelledby="product-tab-qas">
                                <div class="product-qas-content">
                                    <div class="alert alert-info">Under Construction!!!</div>
                                </div><!-- End .product-tags-content -->
                            </div><!-- End .tab-pane -->

                            <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                <div class="product-reviews-content">
                                    <div>
                                        @if(count($product->reviews))
                                            @foreach($product->reviews as $review)
                                                <div class="ratings-container mb-0">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:{{$review->rating * 20}}%"></span>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-0"><small>By Admin ({{$review->created_at->diffForHumans()}})</small></p>
                                                <p>{{$review->review}}</p>
                                            @endforeach
                                        @else
                                            <div class="alert alert-info">No reviews found for this product.</div>
                                        @endif
                                    </div>
                                </div><!-- End .product-reviews-content -->
                            </div><!-- End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-single-tabs -->
                </div><!-- End .col-lg-9 -->

                <div class="sidebar-overlay"></div>
                <div class="sidebar-toggle"><i class="icon-sliders"></i></div>
                <aside class="sidebar-product col-lg-3 padding-left-lg mobile-sidebar">
                    <div class="sidebar-wrapper">
{{--                        <div class="widget widget-brand">--}}
{{--                            <a href="#">--}}
{{--                                <img src="assets/images/product-brand.png" alt="brand name">--}}
{{--                            </a>--}}
{{--                        </div><!-- End .widget -->--}}

                        <div class="widget widget-info">
                            <ul>
                                <li>
                                    <i class="icon-shipping"></i>
                                    <h4>FREE<br>SHIPPING</h4>
                                </li>
                                <li>
                                    <i class="icon-us-dollar"></i>
                                    <h4>100% MONEY<br>BACK GUARANTEE</h4>
                                </li>
                                <li>
                                    <i class="icon-online-support"></i>
                                    <h4>ONLINE<br>SUPPORT 24/7</h4>
                                </li>
                            </ul>
                        </div><!-- End .widget -->
                    </div>
                </aside><!-- End .col-md-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

{{--        <div class="featured-section">--}}
{{--            <div class="container">--}}
{{--                <h2 class="carousel-title">Featured Products</h2>--}}

{{--                <div class="featured-products owl-carousel owl-theme owl-dots-top">--}}
{{--                    <div class="product">--}}
{{--                        <figure class="product-image-container">--}}
{{--                            <a href="product.html" class="product-image">--}}
{{--                                <img src="assets/images/products/product-1.jpg" alt="product">--}}
{{--                            </a>--}}
{{--                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
{{--                        </figure>--}}
{{--                        <div class="product-details">--}}
{{--                            <div class="ratings-container">--}}
{{--                                <div class="product-ratings">--}}
{{--                                    <span class="ratings" style="width:80%"></span><!-- End .ratings -->--}}
{{--                                </div><!-- End .product-ratings -->--}}
{{--                            </div><!-- End .product-container -->--}}
{{--                            <h2 class="product-title">--}}
{{--                                <a href="product.html">Pen drive</a>--}}
{{--                            </h2>--}}
{{--                            <div class="price-box">--}}
{{--                                <span class="product-price">$189.00</span>--}}
{{--                            </div><!-- End .price-box -->--}}

{{--                            <div class="product-action">--}}
{{--                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
{{--                                    <span>Add to Wishlist</span>--}}
{{--                                </a>--}}

{{--                                <a href="product.html" class="paction add-cart" title="Add to Cart">--}}
{{--                                    <span>Add to Cart</span>--}}
{{--                                </a>--}}

{{--                                <a href="#" class="paction add-compare" title="Add to Compare">--}}
{{--                                    <span>Add to Compare</span>--}}
{{--                                </a>--}}
{{--                            </div><!-- End .product-action -->--}}
{{--                        </div><!-- End .product-details -->--}}
{{--                    </div><!-- End .product -->--}}

{{--                    <div class="product">--}}
{{--                        <figure class="product-image-container">--}}
{{--                            <a href="product.html" class="product-image">--}}
{{--                                <img src="assets/images/products/product-2.jpg" alt="product">--}}
{{--                            </a>--}}
{{--                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
{{--                        </figure>--}}
{{--                        <div class="product-details">--}}
{{--                            <div class="ratings-container">--}}
{{--                                <div class="product-ratings">--}}
{{--                                    <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                </div><!-- End .product-ratings -->--}}
{{--                            </div><!-- End .product-container -->--}}
{{--                            <h2 class="product-title">--}}
{{--                                <a href="product.html">Headphone</a>--}}
{{--                            </h2>--}}
{{--                            <div class="price-box">--}}
{{--                                <span class="product-price">$55.00</span>--}}
{{--                            </div><!-- End .price-box -->--}}

{{--                            <div class="product-action">--}}
{{--                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
{{--                                    <span>Add to Wishlist</span>--}}
{{--                                </a>--}}

{{--                                <a href="product.html" class="paction add-cart" title="Add to Cart">--}}
{{--                                    <span>Add to Cart</span>--}}
{{--                                </a>--}}

{{--                                <a href="#" class="paction add-compare" title="Add to Compare">--}}
{{--                                    <span>Add to Compare</span>--}}
{{--                                </a>--}}
{{--                            </div><!-- End .product-action -->--}}
{{--                        </div><!-- End .product-details -->--}}
{{--                    </div><!-- End .product -->--}}

{{--                    <div class="product">--}}
{{--                        <figure class="product-image-container">--}}
{{--                            <a href="product.html" class="product-image">--}}
{{--                                <img src="assets/images/products/product-3.jpg" alt="product">--}}
{{--                            </a>--}}
{{--                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
{{--                        </figure>--}}
{{--                        <div class="product-details">--}}
{{--                            <div class="ratings-container">--}}
{{--                                <div class="product-ratings">--}}
{{--                                    <span class="ratings" style="width:40%"></span><!-- End .ratings -->--}}
{{--                                </div><!-- End .product-ratings -->--}}
{{--                            </div><!-- End .product-container -->--}}
{{--                            <h2 class="product-title">--}}
{{--                                <a href="product.html">Computer Mouse</a>--}}
{{--                            </h2>--}}
{{--                            <div class="price-box">--}}
{{--                                <span class="product-price">$31.00</span>--}}
{{--                            </div><!-- End .price-box -->--}}

{{--                            <div class="product-action">--}}
{{--                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
{{--                                    <span>Add to Wishlist</span>--}}
{{--                                </a>--}}

{{--                                <a href="product.html" class="paction add-cart" title="Add to Cart">--}}
{{--                                    <span>Add to Cart</span>--}}
{{--                                </a>--}}

{{--                                <a href="#" class="paction add-compare" title="Add to Compare">--}}
{{--                                    <span>Add to Compare</span>--}}
{{--                                </a>--}}
{{--                            </div><!-- End .product-action -->--}}
{{--                        </div><!-- End .product-details -->--}}
{{--                    </div><!-- End .product -->--}}

{{--                    <div class="product">--}}
{{--                        <figure class="product-image-container">--}}
{{--                            <a href="product.html" class="product-image">--}}
{{--                                <img src="assets/images/products/product-4.jpg" alt="product">--}}
{{--                            </a>--}}
{{--                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
{{--                        </figure>--}}
{{--                        <div class="product-details">--}}
{{--                            <div class="ratings-container">--}}
{{--                                <div class="product-ratings">--}}
{{--                                    <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                </div><!-- End .product-ratings -->--}}
{{--                            </div><!-- End .product-container -->--}}
{{--                            <h2 class="product-title">--}}
{{--                                <a href="product.html">Camera</a>--}}
{{--                            </h2>--}}
{{--                            <div class="price-box">--}}
{{--                                <span class="product-price">$335.00</span>--}}
{{--                            </div><!-- End .price-box -->--}}

{{--                            <div class="product-action">--}}
{{--                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
{{--                                    <span>Add to Wishlist</span>--}}
{{--                                </a>--}}

{{--                                <a href="product.html" class="paction add-cart" title="Add to Cart">--}}
{{--                                    <span>Add to Cart</span>--}}
{{--                                </a>--}}

{{--                                <a href="#" class="paction add-compare" title="Add to Compare">--}}
{{--                                    <span>Add to Compare</span>--}}
{{--                                </a>--}}
{{--                            </div><!-- End .product-action -->--}}
{{--                        </div><!-- End .product-details -->--}}
{{--                    </div><!-- End .product -->--}}

{{--                    <div class="product">--}}
{{--                        <figure class="product-image-container">--}}
{{--                            <a href="product.html" class="product-image">--}}
{{--                                <img src="assets/images/products/product-5.jpg" alt="product">--}}
{{--                            </a>--}}
{{--                            <a href="ajax/product-quick-view.html" class="btn-quickview">Quick View</a>--}}
{{--                        </figure>--}}
{{--                        <div class="product-details">--}}
{{--                            <div class="ratings-container">--}}
{{--                                <div class="product-ratings">--}}
{{--                                    <span class="ratings" style="width:50%"></span><!-- End .ratings -->--}}
{{--                                </div><!-- End .product-ratings -->--}}
{{--                            </div><!-- End .product-container -->--}}
{{--                            <h2 class="product-title">--}}
{{--                                <a href="product.html">Leather Boots</a>--}}
{{--                            </h2>--}}
{{--                            <div class="price-box">--}}
{{--                                <span class="product-price">$60.00</span>--}}
{{--                            </div><!-- End .price-box -->--}}

{{--                            <div class="product-action">--}}
{{--                                <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
{{--                                    <span>Add to Wishlist</span>--}}
{{--                                </a>--}}

{{--                                <a href="product.html" class="paction add-cart" title="Add to Cart">--}}
{{--                                    <span>Add to Cart</span>--}}
{{--                                </a>--}}

{{--                                <a href="#" class="paction add-compare" title="Add to Compare">--}}
{{--                                    <span>Add to Compare</span>--}}
{{--                                </a>--}}
{{--                            </div><!-- End .product-action -->--}}
{{--                        </div><!-- End .product-details -->--}}
{{--                    </div><!-- End .product -->--}}
{{--                </div><!-- End .featured-proucts -->--}}
{{--            </div><!-- End .container -->--}}
{{--        </div><!-- End .featured-section -->--}}
@endsection
