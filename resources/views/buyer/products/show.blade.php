@extends('buyer.layouts.app')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav mt-5">
        <div class="container">
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
                                        <img class="product-single-image"
                                             src="{{str_replace("public","/storage",$product->featured_image)}}"
                                             data-zoom-image="{{str_replace("public","/storage",$product->featured_image)}}"/>
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
                                    <img src="/assets1/images/svg/shop/shop.svg" class="mr-2 d-inline-block" width="15"
                                         alt="">

                                    <a href="{{route('buyer.shop.show', [$product->seller->shop_slug])}}">{{$product->seller->shop_name}}</a>
                                </p>

                                <div class="product-desc">
                                    <p>{{Str::limit($product->description, 100)}}</p>
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
                                            <a href="{{route('buyer.products.cart.create', [$product->id])}}"
                                               class="paction add-cart" title="Add to Cart">
                                                <span>Add to Cart</span>
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{route('buyer.products.cart.create', [$product->id, 'remove'])}}"
                                           class="paction add-cart" title="Add to Cart">
                                            <span>Remove from Cart</span>
                                        </a>
                                    @endif
                                    @if(auth()->check())
                                        @php($condition = auth('buyer')->user()->hasWish($product->id))
                                        <a href="{{route('buyer.products.wishlist.create', [$product->id])}}"
                                           class="paction add-wishlist"
                                           title="{{$condition ? "Remove from" : "Add to"}} Wishlist"
                                           @if($condition) style="background-color: #9a2693;color: white;" @endif
                                        >
                                            <span>{{$condition ? "Remove from" : "Add to"}} Wishlist</span>
                                        </a>
                                    @endif
                                </div><!-- End .product-action -->

                                <div class="">
                                    <h4>Share:</h4>
                                    <hr class="mt-1 mb-2">
                                    <div class="post-sharing">
                                        <ul class="list-inline">
                                            <li>
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{route('buyer.products.show', [$product->slug])}}" target="_blank" class="fb-button btn btn-primary btn-icon">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://twitter.com/intent/tweet?text={{$product->name}}&amp;url={{route('buyer.products.show', [$product->slug])}}" target="_blank" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- End .product single-share -->
                            </div><!-- End .product-single-details -->
                        </div><!-- End .col-lg-5 -->
                    </div><!-- End .row -->
                </div><!-- End .product-single-container -->

                <div class="product-single-tabs">
                    <ul class="nav nav-tabs" id="productTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab"
                               href="#product-desc-content" role="tab" aria-controls="product-desc-content"
                               aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-qas" data-toggle="tab" href="#product-qas-content"
                               role="tab" aria-controls="product-qas-content" aria-selected="false">Q&As</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-reviews" data-toggle="tab"
                               href="#product-reviews-content" role="tab" aria-controls="product-reviews-content"
                               aria-selected="false">Reviews</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                             aria-labelledby="product-tab-desc">
                            <div class="product-desc-content">
                                <p>{{$product->description}}</p>
                            </div><!-- End .product-desc-content -->
                        </div><!-- End .tab-pane -->

                        <div class="tab-pane fade" id="product-qas-content" role="tabpanel"
                             aria-labelledby="product-tab-qas">
                            <div class="product-qas-content">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @auth('buyer')
                                    <form action="{{route('buyer.products.questions.store', [$product->id])}}" method="POST">
                                        @csrf
                                        <h3>Ask Question</h3>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input id="title" type="text" name="question_title" class="form-control" value="{{old('question_title')}}" />
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="question_description" class="form-control">{{old('question_description')}}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                @endauth


                                @if($product->questions->count())
                                    @foreach($product->questions as $question)
                                        <div>
                                            <p>
                                                <strong>{{$question->question_title}}</strong>
                                                <br>
                                                {{$question->question_description}}
                                                <br>
                                                <small>By {{$question->buyer->name}} | {{$question->created_at->diffForHumans()}}</small>
                                            </p>
                                            @if(!empty($question->answer_description))
                                                <div class="alert alert-info">
                                                    <strong>Seller Response:</strong>
                                                    <br>
                                                    {{$question->answer_description}}
                                                </div>
                                            @endif
                                            <hr class="my-1">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        No questions found.
                                    </div>
                                @endif

                            </div>
                        </div><!-- End .tab-pane -->

                        <div class="tab-pane fade" id="product-reviews-content" role="tabpanel"
                             aria-labelledby="product-tab-reviews">
                            <div class="product-reviews-content">
                                <div>
                                    @if(count($product->reviews))
                                        @foreach($product->reviews as $review)
                                            <div class="ratings-container mb-0">
                                                <div class="product-ratings">
                                                    <span class="ratings"
                                                          style="width:{{$review->rating * 20}}%"></span>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-0">
                                                <small>By {{ !is_null($review->product_order) && !is_null($review->product_order->order) && !is_null($review->product_order->order->buyer) ? $review->product_order->order->buyer->name : 'GharPey Customer' }}
                                                    ({{$review->created_at->diffForHumans()}})</small></p>
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
@endsection

@section('styles')
    <style>
        .fb-button.btn-primary:focus,
        .fb-button.btn-primary:hover,
        .fb-button.btn-primary {
            background-color: #3B5998 !important;
            border-color: #3B5998 !important;
            padding: 0.5rem;
            min-width: 50px;
        }

        .tw-button.btn-primary:hover,
        .tw-button.btn-primary:focus,
        .tw-button.btn-primary {
            background-color: #00B6F1 !important;
            border-color: #00B6F1 !important;
            padding: 0.5rem;
            min-width: 50px;
        }

        .post-sharing span,
        .post-sharing li {
            display: inline-block !important;
        }

    </style>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            @if($errors->any() || isset($qa))
                $('#productTab a[href="#product-qas-content"]').tab('show');
                $('html, body').animate({
                    scrollTop: $("#productTab").offset().top
                }, 2000);
            @endif
        });
    </script>
@endsection
