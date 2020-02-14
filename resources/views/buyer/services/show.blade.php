@extends('buyer.layouts.app')

@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        @media screen and (max-width: 576px) {
            .m-padding-20 {
                padding-top: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="jumbotron jumbotron-fluid"
         style="background: linear-gradient(rgba(0, 0, 0, 0.65) 35%, rgba(0, 0, 0, 0.8) 80%), url('{{ asset(str_replace("public","storage", $service->featured_image)) }}');
                 background-repeat: no-repeat;
                 background-size: cover;
                 background-color: #f5f8fa;
                 color: #fff;">
        <div class="container margin-top-50">
            @if((isset($location) && !is_null($location) && $location->city_id == $city->id))
                <h4 class="display-6 text-center m-padding-20">{{ $city->city }}, {{ $city->state_code }}</h4>
            @elseif(isset($location) && !is_null($location))
                <h4 class="display-6 text-center m-padding-20">{{ $location->city->city }}
                    , {{ $location->city->state_code }}</h4>
            @endif

            <div class="col-lg-6 col-md-7 col-sm-9 mx-auto" style="background-color: rgb(255, 255, 255);color: #000;">
                <div class="p-sm-5 pt-5 pb-5">
                    <h3 class="display-6 text-center">Where do you need {{$service->name}}?</h3>

                    <div class="input-group mb-3">
                        <input id="city_id_input"
                               value="{{ $location->city_id == $city->id ?$location->zip:$location->zip }}" type="text"
                               class="form-control" placeholder="Enter your zip code" aria-label="Enter your zip code"
                               aria-describedby="go-button">
                        <div class="input-group-append">
                            <button class="btn btn-success font-weight-bold" type="button" id="go-button"
                                    data-toggle="modal" data-target="#exampleModal">GET A FREE QUOTE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <input type="hidden" class="service-name" value="{{$service->name}}">
    <section class="bg-primary">
        <div class="container text-left">
            @if ($errors->any())
                <div class="alert alert-danger mb-5" id="errorsDiv">
                    <ul>
                        @if ($errors->has('city_id'))
                            <li>The zip code is invalid or this service is not available for your location.</li>
                            {{--<li>{{$errors->first('city_id')}}</li>--}}
                        @endif
                        @foreach($service->questions as $q)
                            @foreach ($errors->all() as $error)
                                @if(str_contains($error, 'answer-'. $q->id))
                                    <li>{{ str_replace('answer-'. $q->id, $q->name, $error) }}</li>
                                @endif
                            @endforeach
                        @endforeach
                    </ul>
                </div>

                @section('scripts')
                    <script>
                        $(document).ready(function() {
                            $('html, body').animate({
                                scrollTop: $("#errorsDiv").offset().top - 100
                            }, 2000);
                        });
                    </script>
                @append
            @endif

            @if (session('status'))
                <div class="alert alert-success mb-5">
                    {{ session('status') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8 col-md-10 col-sm-12 header-line">
                    <h1 class="header-title-1 tp-margin-bottom--quad">{{$service->name}}</h1>
                </div><!-- .col-8 -->
            </div><!-- .row -->

            <div class="row">
                <div class="col-lg-12">
                    <div>{!! $service->description !!}</div>
                </div><!-- .col-8 -->
            </div>

        {{--<button class="btn btn-primary">Ask for Quote</button><!-- Button trigger modal -->--}}
        {{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">--}}
        {{--Ask for Quote--}}
        {{--</button>--}}

        <!-- Modal -->
            <div class="modal fade service-question-modal questions-modal" id="exampleModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{url('/services/'.$service->id)}}" method="POST" enctype="multipart/form-data"
                              id="questionsForm">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Answer these questions for your
                                    quote</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input id="city_id" type="hidden" name="city_id"
                                       value="{{$location->city_id == $city->id ? $location->zip : $city->areas()->first()->zip}}"/>
                                <div class="alert alert-danger" id="error" style="display: none;"></div>
                                @php($i = 1)
                                @php($question_ids = [])
                                @foreach($service->questions as $question)
                                    @php($required = false)
                                    @php($continue = false)
                                    @foreach($question->rules as $rule)
                                        @if($rule->rule == \App\Models\ServiceQuestionValidationRule::AUTH_REQUIRED)
                                            @unless(auth()->check())
                                                @php($continue = true)
                                            @endunless
                                        @endif
                                        @if($rule->rule == \App\Models\ServiceQuestionValidationRule::AUTH_GUEST)
                                            @unless(auth()->guest())
                                                @php($continue = true)
                                            @endunless
                                        @endif
                                        @if($rule->rule == \App\Models\ServiceQuestionValidationRule::REQUIRED)
                                            @php($required = $question->required = true)
                                        @endif
                                    @endforeach
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
        </div>
    </section>
    <!--
    <section class="gallery-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 col-sm-12 header-line">
                    <h1 class="header-title-1 tp-margin-bottom--quad">Gallery</h1>
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </section>
    -->
@endsection


@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".datepicker").datepicker({minDate: "+1D", maxDate: "+2M", defaultDate: new Date()});
            $(".datepicker").datepicker("setDate", "+1d");

            var city = $('#city_id');
            var city_input = $('#city_id_input');

            city_input.on('keyup', function () {
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
                        if ($(this).data("required") == 1)
                            $('#skip').hide();
                        else
                            $('#skip').show();

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
                        if ($(this).data("required") == 1)
                            $('#skip').hide();
                        else
                            $('#skip').show();

                        $("#service-question-" + questions[currentQuestionIndex]).slideDown(400);

                    });
                }
            });
        });

        $('.input-service-name').text($(".service-name").val());
    </script>

    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
@endsection
