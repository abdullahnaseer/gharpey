<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
            <h3 class="kt-portlet__head-title">
                Service Information
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="form-group">
            {!! Form::label('service_id', 'Service', ['class' => "col-form-label"]) !!}
            <select name="service_id" id="service_id" class="form-control select2-js" required="required">
                @foreach($categories as $category)
                    <optgroup label="{{$category->name}}">
                        @foreach($category->services as $service)
                            <option value="{{$service->id}}"  @if(old('service_id') == $service->id) selected @endif >{{$service->name}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            {{--                {!! Form::select('service_id', $services->pluck('name', 'id'), null, ['class' => "form-control", "required" => "required"]) !!}--}}
        </div>
        <div class="form-group">
            {!! Form::label('price', 'Price', ['class' => "col-form-label"]) !!}
            {!! Form::number('price', null, ['class' => "form-control", "required" => "required"]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('short_description', 'Short Description', ['class' => "col-form-label"]) !!}
            {!! Form::textarea('short_description', null, ['class' => "form-control", "required" => "required"]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('long_description', 'Long Description', ['class' => "col-form-label"]) !!}
            {!! Form::textarea('long_description', null, ['class' => "form-control", "required" => "required", 'id' => 'editor']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('cities', 'Cities Available', ['class' => "col-form-label"]) !!}

            <select name="cities" id="cities" class="form-control select2-js-multiple" required="required" multiple="multiple">
                @foreach($states as $state)
                    <optgroup label="{{$state->name}}">
                        @foreach($state->cities as $city)
                            <option value="{{$city->id}}"  @if(collect(old('cities', []))->contains($service->id)) selected @endif >{{$city->name}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            {!! Form::label('featured_image', 'Featured Image', ['class' => "col-form-label"]) !!}
            <br>
            {!! Form::file('featured_image', [
                    'onchange' => "document.getElementById('featured_image_preview').style.display = 'block';document.getElementById('featured_image_preview').src = window.URL.createObjectURL(this.files[0])"
            ]) !!}
            <div class="mt-4" style="max-width: 300px">
                <img id="featured_image_preview" style="display: none" alt="Featured Image" class="img-thumbnail" />
            </div>
        </div>
    </div>
</div>

<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
            <h3 class="kt-portlet__head-title">
                Questions
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                </div>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div id="question_portlets">
            @if(old('type'))
                @foreach(old('type') as $question)
                    @include('seller.services.includes.question-portlet', [
                        'title' => old('title.'.$loop->index),
                        'question' => old('question.'.$loop->index),
                        'type' => old('type.'.$loop->index),
                        'is_required' => old('is_required.'.$loop->index),
                        'price_effect_yes' => old('price_effect_yes.'.$loop->index),
                        'price_effect_no' => old('price_effect_no.'.$loop->index),
                        'choice_texts' => old('choice_text.'.$loop->index),
                        'choice_price_effects' => old('choice_price_effect.'.$loop->index),
                        'question_index' => $loop->index
                    ])
                @endforeach
            @elseif(isset($model))
                @foreach($model->questions as $question)
                    @include('seller.services.includes.question-portlet', [
                        'title' => $question->title,
                        'question' => $question->question,
                        'type' => $question->type,
                        'is_required' => $question->is_required,
                        'price_effect_yes' => 1,
                        'price_effect_no' => 1,
                        'choice_texts' => $question->type->isSelect() ? old('choice_text.'.$loop->index) : [],
                        'choice_price_effects' => $question->type->isSelect() ? old('choice_price_effect.'.$loop->index) : [],
                        'question_index' => $loop->index
                    ])
                @endforeach
            @endif
        </div>

        <button id="add-question" class="btn btn-outline-success" type="button">Add Question</button>
    </div>
</div>
<button class="btn btn-primary" type="submit">Submit</button>