<div class="kt-portlet kt-portlet--sortable question-portlet">
    <div class="kt-portlet__head question-head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Question
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-group">
{{--                <button onclick="return false;" role="button" class="btn btn-sm btn-outline-success btn-elevate up-question-btn">Rules</button>--}}
                <button onclick="return false;" role="button" class="btn btn-sm btn-icon btn-outline-success btn-elevate btn-icon-md up-question-btn"><i class="la la-arrow-up"></i></button>
                <button onclick="return false;" role="button" class="btn btn-sm btn-icon btn-outline-success btn-elevate btn-icon-md down-question-btn"><i class="la la-arrow-down"></i></button>
                <button onclick="return false;" role="button" class="btn btn-sm btn-icon btn-outline-danger btn-elevate btn-icon-md remove-question-btn"><i class="la la-close"></i></button>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="form-group col-sm-3 col-md-2 col-lg-2">
                {!! Form::text('name[]', $title ?? '', ['class' => "form-control input-name", "required" => "required", "placeholder" => "Name"]) !!}
            </div>
            <div class="form-group col-sm-3 col-md-3 col-lg-2">
                {!! Form::select('type[]', \App\Helpers\ServiceQuestionType\ServiceQuestionType::TYPES, $type ?? null, ['class' => "form-control type select-type", "required" => "required"]) !!}
            </div>
            <div class="form-group col-sm-6 col-md-7 col-lg-8">
                {!! Form::text('question[]', $question ?? '', ['class' => "form-control input-question", "required" => "required", "placeholder" => "Question Text"]) !!}
            </div>
        </div>

        <div class="choices-container " style=" {{ (isset($type) && ($type === 'select.single' || $type === 'select.multiple')) ? '' : 'display: none;'}}">
            <h5>Select Choices</h5>
            <hr>
            <div class="kt_sortable_portlets choice-portlets">
                @if(!empty($choice_texts) && !empty($choice_price_effects))
                    @for($choiceIndex = 0, $choiceIndexMax = count($choice_texts); $choiceIndex < $choiceIndexMax; $choiceIndex++)
                        @include('seller.services.includes.choice-portlet', [
                            'choice_text' => $choice_texts[$choiceIndex],
                            'choice_price_effect' => $choice_price_effects[$choiceIndex],
                        ])
                    @endfor
                @endif
            </div>

            <button class="btn btn-outline-success btn-add-choice" type="button">Add Choice</button>
        </div>

{{--        <div class="boolean-price-effect" style="{{ (isset($type) && ($type === \App\Helpers\ServiceQuestionType\ServiceQuestionType::SELECT)) ? '' : 'display: none;'}}">--}}
{{--            <h5>Price Effect</h5>--}}
{{--            <hr>--}}
{{--            <div class="kt_sortable_portlets">--}}
{{--                <div class="row">--}}
{{--                    <div class="form-group col-sm-6">--}}
{{--                        {!! Form::label('price_effect_yes', 'Price Effect (Yes)', ['class' => "col-form-label"]) !!}--}}
{{--                        {!! Form::number('price_effect_yes[]', $price_effect_yes ?? 0, ['class' => "form-control input-price-effect-yes", "required" => "required"]) !!}--}}
{{--                    </div>--}}
{{--                    <div class="form-group col-sm-6">--}}
{{--                        {!! Form::label('price_effect_no', 'Price Effect (No)', ['class' => "col-form-label"]) !!}--}}
{{--                        {!! Form::number('price_effect_no[]', $price_effect_no ?? 0, ['class' => "form-control input-price-effect-no", "required" => "required"]) !!}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
