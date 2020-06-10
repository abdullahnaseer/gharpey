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
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" @if(app('request')->input('city_id') == $city->id) selected @endif>{{$city->name}}</option>
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

                                    <a href="#questionsModal" class="paction add-cart" title="Order Now" data-toggle="modal" data-target="#questionsModal" data-id="{{$service_seller->id}}">
                                        <span>Order Now</span>
                                    </a>

                                    {{--                                    <a href="#" class="paction add-compare" title="Add to Compare">--}}
                                    {{--                                        <span>Add to Compare</span>--}}
                                    {{--                                    </a>--}}
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

        <div class="modal fade service-question-modal questions-modal" id="questionsModal" tabindex="-1" role="dialog"
             aria-labelledby="questionsModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{route('buyer.services.store', [$service->id])}}" method="POST" enctype="multipart/form-data"
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
                                   value="{{$city->id}}"/>
                            <div class="alert alert-danger" id="error" style="display: none;"></div>
                            @php($i = 1)
                            @php($question_ids = [])
                            @foreach($service->questions as $question)
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
                                            $service->questions
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
    @endif
@endsection


@section('scripts')
    @if(isset($service_sellers))
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
                    var question = $("#service-question-" + questions[currentQuestionIndex]);
                    var type = question.data("type");
                    var required = question.data("required");

                    if (type == '{!! str_replace( "\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeSelectMultiple::class ) !!}') {
                        var inpObj = $("input[name='answer-" + questions[currentQuestionIndex] + "[]']:checked");
                        if (required == 1) {
                            if (!inpObj.length) {
                                error.html("Please select one of these options.");
                                error.slideDown();
                                return false;
                            }
                        }
                    } else if (type == '{!! str_replace( "\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeFileMultiple::class) !!}') {
                        var inpObj = document.getElementsByName("answer-" + questions[currentQuestionIndex] + "[]");
                        if (!inpObj[0].checkValidity()) {
                            error.html(inpObj[0].validationMessage);
                            error.slideDown();
                            return false;
                        }
                    } else if (type == '{!! str_replace( "\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeTextMultiline::class) !!}') {
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
