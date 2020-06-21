@extends('buyer.layouts.app')

@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav mt-5">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{route('buyer.services.index')}}">Services</a></li>
                <li class="breadcrumb-item"><a href="{{route('buyer.services.show', [$service->slug, 'city_id' => $city ? $city->id : ''])}}">{{$service->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$service_seller->seller->shop_name}}</li>
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
                                        <img class="product-single-image" src="{{str_replace("public","/storage",$service->featured_image)}}" data-zoom-image="assets/images/products/zoom/product-1-big.jpg"/>
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
                                    <img src="{{str_replace("public","/storage",$service->featured_image)}}"/>
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
                                <h1 class="product-title m-0 mb-1" style="line-height: normal;">{{$service->name}}</h1>

                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:{{$service->reviews_average * 20}}%"></span>
                                        <!-- End .ratings -->
                                    </div>
                                    <!-- End .product-ratings -->
                                    <a href="#" class="rating-link">( {{ $service->reviews_count }} Reviews )</a>
                                </div>

                                <div class="price-box">
                                    {{--                                        <span class="old-price">$81.00</span>--}}
                                    <span class="product-price">Rs. {{$service_seller->price}}</span>
                                </div><!-- End .price-box -->

                                <p class="product-location text-left m-b-5">
                                    <img src="/assets1/images/svg/shop/shop.svg" class="mr-2 d-inline-block" width="15" alt="">

                                    <a href="{{route('buyer.shop.show', [$service_seller->seller->shop_slug])}}">{{$service_seller->seller->shop_name}}</a>
                                </p>

                                <div class="product-desc">
                                    <p>{{\Str::limit($service_seller->short_description, 100)}}</p>
                                    
                                    <p>
                                        <strong>Available:</strong> {{$service_seller->cities->pluck('name')->implode(", ")}}
                                    </p>
                                </div><!-- End .product-desc -->

                                <div class="">
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
                                </div>


                                <div class="product-action product-all-icons">
                                    {{--                                        <div class="product-single-qty">--}}
                                    {{--                                            <input class="horizontal-quantity form-control" type="text">--}}
                                    {{--                                        </div><!-- End .product-single-qty -->--}}
                                    <a href="#questionsModal" class="paction add-cart" title="Order Now" data-toggle="modal" data-target="#questionsModal" data-id="{{$service_seller->id}}">
{{--                                    <a href="{{route('buyer.products.cart.create', [$service->id])}}" class="paction add-cart" title="Add to Cart">--}}
                                        <span>Order Now</span>
                                    </a>

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
                                <p>{!! $service_seller->long_description !!}</p>
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
                                    @if(count($service_seller->reviews))
                                        @foreach($service_seller->reviews as $review)
                                            <div class="ratings-container mb-0">
                                                <div class="product-ratings">
                                                    <span class="ratings" style="width:{{$review->rating * 20}}%"></span>
                                                </div>
                                            </div>
                                            <p class="text-muted mb-0"><small>By {{ !is_null($review->buyer) ? $review->buyer->name : 'GharPey Customer' }} ({{$review->created_at->diffForHumans()}})</small></p>
                                            <p>{{$review->review}}</p>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">No reviews found for this service.</div>
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

    <div class="modal fade service-question-modal questions-modal" id="questionsModal" tabindex="-1" role="dialog"
         aria-labelledby="questionsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('buyer.services.sellers.store', [$service->id, $service_seller->id])}}" method="POST" enctype="multipart/form-data"
                      id="questionsForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="questionsModalLabel">Answer these questions for quotation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="service_id" type="hidden" name="service_id"
                               value="{{$service->id}}"/>
                        <input id="service_seller_id" type="hidden" name="service_seller_id"
                               value=""/>
                        <input id="city_id" type="hidden" name="city_id"
                               value="{{request()->input('city_id')}}"/>
                        <div class="alert alert-danger" id="error" style="display: none;"></div>
                        @php($i = 1)
                        @php($question_ids = [])
                        @foreach($service_seller->questions as $question)
                            @php($required = false)
                            @php($continue = false)
                            @if(($question->auth_rule->isOnlyForAuthenticatedUser()))
                                @unless(auth()->check())
                                    @php($continue = true)
                                @endunless
                            @endif
                            @if(($question->auth_rule->isOnlyForGuestUser()))
                                @unless(auth()->guest())
                                    @php($continue = true)
                                @endunless
                            @endif
                            @if($question->is_required || true)  {{-- Forced True--}}
                            @php($required = $question->is_required = true)
                            @endif
                            @continue($continue)
                            <div class="service-question service-question-{{$question->type->text}}"
                                 id="service-question-{{ (empty($question->id) ? $question->name : $question->id) }}"
                                 @if($i != 1) style="display: none;" @endif
                                 data-required="{{$required}}"
                                 data-type="{{$question->type->getTypeClass()}}">

                                <h3>{{$question->question}}{{ $required ? '*' : '' }} </h3>
                                {!! $question->type->getHtml("answer-" . (empty($question->id) ? $question->name : $question->id), null, true, ['class' => 'form-control'], $question->choices) !!}
                            </div>
                            @php(array_push($question_ids, (empty($question->id) ? $question->name : ((int) $question->id)) ))
                            @php($i++)
                        @endforeach
                        <div class="alert alert-success" style="display: none;" id="loading">Submiting
                            Request...
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                        @unless(isset($question_ids[0]) && (
                                        $service_seller->questions
                                        ->where(is_string($question_ids[0]) ? 'name' : 'id', $question_ids[0])
                                        ->first()->is_required
                                        )
                                    )
                            <button type="button" class="btn btn-outline-danger" id="skip">Skip</button>
                        @endunless
                        <button type="button" class="btn btn-primary" id="back" style="display: none;">Back
                        </button>
                        <button type="button" class="btn btn-primary" id="next">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('buyer.services.sellers.questions-script')
@endsection
