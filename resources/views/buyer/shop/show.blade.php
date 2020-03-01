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

                                            <div class="product-action">
                                                {{--                                    <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
                                                {{--                                        <span>Add to Wishlist</span>--}}
                                                {{--                                    </a>--}}

                                                <a href="#questionsModal" class="paction add-cart" title="Order Now" data-toggle="modal" data-target="#questionsModal" data-id="{{$service->pivot->id}}">
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


    @if(isset($services))
        <div class="modal fade service-question-modal questions-modal" id="questionsModal" tabindex="-1" role="dialog"
         aria-labelledby="questionsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('buyer.services.store', [1])}}" method="POST" enctype="multipart/form-data"
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
                               value=""/>
                        <input id="service_seller_id" type="hidden" name="service_seller_id"
                               value="{{$shop->id}}"/>
                        <input id="city_id" type="hidden" name="city_id"
                               value=""/>
                        <div class="alert alert-danger" id="error" style="display: none;"></div>
                        @php($i = 1)
                        @php($question_ids = [])
                        @foreach($service->questions as $question)
                            @php($required = false)
                            @php($continue = false)
                            @if(($question->auth_rule == \App\Models\ServiceQuestion::AUTH_REQUIRED))
                                @unless(auth()->check())
                                    @php($continue = true)
                                @endunless
                            @endif
                            @if(($question->auth_rule == \App\Models\ServiceQuestion::AUTH_GUEST))
                                @unless(auth()->guest())
                                    @php($continue = true)
                                @endunless
                            @endif
                            @if($question->is_required)
                                @php($required = $question->required = true)
                            @endif
                            @continue($continue)
                            <div class="service-question service-question-{{$question->type}}"
                                 id="service-question-{{ $question->id }}"
                                 @if($i != 1) style="display: none;" @endif data-required="{{$required}}"
                                 data-type="{{$question->type}}">
                                <h3>{{$question->question}}{{ $required ? '*' : '' }} </h3>
                                @if($question->type == \App\Models\ServiceQuestion::TYPE_BOOLEAN)
                                    <div class="form-check">
                                        <input name="answer-{{$question->id}}" class="form-check-input"
                                               type="radio" id="answer-boolean-{{$question->id}}-yes" value="1"
                                               @if($required) required
                                               @endif @if(old('answer-'.$question->id, false)) checked @endif>
                                        <label class="form-check-label"
                                               for="answer-boolean-{{$question->id}}-yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="answer-{{$question->id}}" class="form-check-input"
                                               type="radio" id="answer-boolean-{{$question->id}}-no" value="0"
                                               @if($required) required
                                               @endif @unless(old('answer-'.$question->id, false)) checked @endunless>
                                        <label class="form-check-label"
                                               for="answer-boolean-{{$question->id}}-no">
                                            No
                                        </label>
                                    </div>
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_TEXT)
                                    @if($question->name == 'guest.email')
                                        <input type="email" name="answer-{{$question->id}}" class="form-control"
                                               @if($required) required
                                               @endif value="{{old('answer-'.$question->id)}}"/>
                                    @elseif($question->name == 'guest.phone')
                                        <input type="tel" name="answer-{{$question->id}}" class="form-control"
                                               @if($required) required
                                               @endif value="{{old('answer-'.$question->id)}}"/>
                                    @else
                                        <input type="text" name="answer-{{$question->id}}" class="form-control"
                                               @if($required) required
                                               @endif value="{{old('answer-'.$question->id)}}"/>
                                    @endif
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_TEXT_MULTILINE)
                                    <textarea name="answer-{{$question->id}}" class="form-control"
                                              @if($required) required @endif>{{old('answer-'.$question->id)}}</textarea>
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_DATE)
                                    <input type="text" name="answer-{{$question->id}}"
                                           class="form-control datepicker" autocomplete="off"
                                           @if($required) required
                                           @endif value="{{old('answer-'.$question->id, \Carbon\Carbon::today()->toDateString())}}"/>
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_TIME)
                                    <input type="time" name="answer-{{$question->id}}" class="form-control"
                                           @if($required) required
                                           @endif value="{{old('answer-'.$question->id)}}"/>
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_DATE_TIME)
                                    <input type="datetime-local" name="answer-{{$question->id}}"
                                           class="form-control" @if($required) required
                                           @endif value="{{old('answer-'.$question->id)}}"/>
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_FILE)
                                    <input type="file" name="answer-{{$question->id}}" @if($required) required
                                           @endif accept="image/*"/>
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_FILE_MULTIPLE)
                                    <input type="file" name="answer-{{$question->id}}[]" @if($required) required
                                           @endif accept="image/*" multiple/>
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_SELECT)
                                    @foreach($question->choices as $choice)
                                        <div class="form-check">
                                            <input name="answer-{{$question->id}}" class="form-check-input"
                                                   type="radio" id="answer-choice-{{$choice->id}}"
                                                   value="{{$choice->id}}" @if($required) required
                                                   @endif @if(old('answer-'.$question->id, false) == $choice->id) checked @endif>
                                            <label class="form-check-label" for="answer-choice-{{$choice->id}}">
                                                {{$choice->choice}}
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif($question->type == \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE)
                                    @foreach($question->choices as $choice)
                                        <div class="form-check">
                                            <input name="answer-{{$question->id}}[]" class="form-check-input"
                                                   type="checkbox" id="answer-choice-{{$choice->id}}"
                                                   value="{{$choice->id}}" @if($required) required
                                                   @endif @if( in_array($choice->id, old('answer-'.$question->id, [])) ) checked @endif>
                                            <label class="form-check-label" for="answer-choice-{{$choice->id}}">
                                                {{$choice->choice}}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @php(array_push($question_ids, $question->id))
                            @php($i++)
                        @endforeach
                        <div class="alert alert-success" style="display: none;" id="loading">Submiting
                            Request...
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                        @unless(isset($question_ids[0]) && $service->questions->where('id', $question_ids[0])->first()->required)
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
    @endif
@endsection



@section('scripts')
    @if(isset($services))
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                $('#questionsModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var service_seller_id = button.data('id') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this);
                    modal.find('#service_seller_id').val(service_seller_id)
                    console.log('service_seller_id: ' + service_seller_id)
                })

                $(".datepicker").datepicker({minDate: "+1D", maxDate: "+2M", defaultDate: new Date()});
                $(".datepicker").datepicker("setDate", "+1d");

                var city = $('#city_id');
                var city_input = $('#city_id_input');

                city.val(parseInt(city_input.val()));
                city_input.on('change', function () {
                    city.val(parseInt(city_input.val()));
                });

                var questions = {!! json_encode($question_ids) !!};
                var currentQuestionIndex = 0;
                var countQuestions = {{ count($question_ids) }};

                $("#next").click(function () {
                    // Check Validity
                    var error = $('#error');
                    var loading = $('#loading');
                    var type = $("#service-question-" + questions[currentQuestionIndex]).data("type");
                    var required = $("#service-question-" + questions[currentQuestionIndex]).data("required");

                    if (type == '{!! \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE !!}') {
                        var inpObj = $("input[name='answer-" + questions[currentQuestionIndex] + "[]']:checked");
                        if (required == 1) {
                            if (!inpObj.length) {
                                error.html("Please select one of these options.");
                                error.slideDown();
                                return false;
                            }
                        }
                    } else if (type == '{!! \App\Models\ServiceQuestion::TYPE_FILE_MULTIPLE!!}') {
                        var inpObj = document.getElementsByName("answer-" + questions[currentQuestionIndex] + "[]");
                        if (!inpObj[0].checkValidity()) {
                            error.html(inpObj[0].validationMessage);
                            error.slideDown();
                            return false;
                        }
                    } else if (type == '{!! \App\Models\ServiceQuestion::TYPE_TEXT_MULTILINE!!}') {
                        var inpObj = $("textarea[name='answer-" + questions[currentQuestionIndex] + "']");
                        if (!inpObj[0].checkValidity()) {
                            error.html(inpObj[0].validationMessage);
                            error.slideDown();
                            return false;
                        }
                    } else {
                        var inpObj = $("input[name='answer-" + questions[currentQuestionIndex] + "']");
                        if (!inpObj[0].checkValidity()) {
                            error.html(inpObj[0].validationMessage);
                            error.slideDown();
                            return false;
                        }
                    }
                    error.slideUp();


                    $("#service-question-" + questions[currentQuestionIndex]).slideUp(400, function () {
                        // Animation complete.
                        if (currentQuestionIndex >= countQuestions - 1) // Check if last question
                        {
                            loading.slideDown();
                            $('#back').hide();
                            $('#questionsForm').submit();
                            console.log('Last question');
                        } else {
                            currentQuestionIndex++;
                            if ($("#service-question-" + questions[currentQuestionIndex]).data("required") == 1)
                                $('#skip').hide();
                            else
                            {
                                if (currentQuestionIndex < countQuestions - 1) // Check if not last question
                                    $('#skip').show();
                            }

                            $('#back').show();
                            $("#service-question-" + questions[currentQuestionIndex]).slideDown(400);
                        }
                    });
                });


                $("#back").click(function () {
                    if (currentQuestionIndex > 0) // Check if first question
                    {
                        $("#service-question-" + questions[currentQuestionIndex]).slideUp(400, function () {
                            // Animation complete.
                            currentQuestionIndex--;
                            if (currentQuestionIndex <= 0) {
                                $('#back').hide();
                            }
                            if ($("#service-question-" + questions[currentQuestionIndex]).data("required") == 1)
                                $('#skip').hide();
                            else
                            {
                                if (currentQuestionIndex < countQuestions - 1) // Check if not last question
                                    $('#skip').show();
                            }

                            $("#service-question-" + questions[currentQuestionIndex]).slideDown(400);

                        });
                    }
                });

                $("#skip").click(function () {
                    $("#service-question-" + questions[currentQuestionIndex]).slideUp(400, function () {
                        // Animation complete.
                        if (currentQuestionIndex >= countQuestions - 1) // Check if last question
                        {
                            loading.slideDown();
                            $('#back').hide();
                            $('#questionsForm').submit();
                            console.log('Last question');
                        } else {
                            currentQuestionIndex++;
                            if ($("#service-question-" + questions[currentQuestionIndex]).data("required") == 1)
                                $('#skip').hide();
                            else
                            {
                                if (currentQuestionIndex < countQuestions - 1) // Check if not last question
                                    $('#skip').show();
                            }

                            $('#back').show();
                            $("#service-question-" + questions[currentQuestionIndex]).slideDown(400);
                        }
                    });
                });

                $('.input-service-name').text($(".service-name").val());
            });


        </script>

        <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
    @endif
@endsection
