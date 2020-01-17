@extends('admin.layouts.dashboard', ['page_title' => "Service Categories"])

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('admin.services.index') }}" class="kt-subheader__breadcrumbs-link">Services</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Create New</span>
@endsection

@section('breadcrumb-elements')
    <a class="btn btn-brand btn-elevate btn-icon-sm"  href="{{route('admin.services.index')}}" data-toggle="modal" data-target="#createModal">
        <i class="la la-arrow-left"></i>
        Back
    </a>
@endsection

@push('styles')

@endpush

@section('content')
    @php($i = 0)
    {{ Form::open(['route' => 'admin.services.store', 'method' => 'POST', 'files' => true]) }}
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
                {!! Form::label('name', 'Name', ['class' => "col-form-label"]) !!}
                {!! Form::text('name', null, ['class' => "form-control", "required" => "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description', ['class' => "col-form-label"]) !!}
                {!! Form::textarea('description', null, ['class' => "form-control", "required" => "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Category', ['class' => "col-form-label"]) !!}
                {!! Form::select('category_id', $categories->pluck('name', 'id'), null, ['class' => "form-control", "required" => "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('featured_image', 'Featured Image', ['class' => "col-form-label"]) !!}
                {!! Form::file('featured_image') !!}
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
            <div id="kt_sortable_portlets">

                @if(old('type'))
                    @foreach(old('type') as $question)
                        <div class="kt-portlet kt-portlet--sortable">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Question
                                    </h3>
                                </div>
                                <div class="kt-portlet__head-toolbar">
                                    <div class="kt-portlet__head-group">
                                        <button role="button" class="btn btn-sm btn-icon btn-success btn-elevate btn-icon-md remove-question-btn"><i class="la la-close"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="form-group row">
                                    {!! Form::label('title', 'Title', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('title['.$loop->index.']', null, ['class' => "form-control", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('question', 'Question', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('question['.$loop->index.']', null, ['class' => "form-control", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('type', 'Type', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('type['.$loop->index.']', array_combine(\App\Models\ServiceQuestion::TYPES, \App\Models\ServiceQuestion::TYPES), null, ['class' => "form-control type", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('auth_type', 'Auth Type', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('auth_type['.$loop->index.']', array_combine(\App\Models\ServiceQuestion::AUTH_RULES, \App\Models\ServiceQuestion::AUTH_RULES), null, ['class' => "form-control", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('is_required', 'Is Required?', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('is_required['.$loop->index.']', [true => 'yes' , false => 'no'], null, ['class' => "form-control", "required" => "required"]) !!}
                                    </div>
                                </div>

                                <hr>

                                <div class="choices mt-3" style="display: {{ ($question === \App\Models\ServiceQuestion::TYPE_SELECT || $question === \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE) ? "block" : "none" }};">
                                    <div class="choice-inputs">
                                        @if(array_key_exists($loop->index, old('choices', [])) && ($question === \App\Models\ServiceQuestion::TYPE_SELECT || $question === \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE))
                                            @foreach(old('choices', [])[$loop->index] as $choice)
                                                <div class="form-group">
                                                    <label>Choice</label>
                                                    <input type="text" name="choices[{{$loop->parent->index}}][]" class="form-control" value="{{$choice}}" />
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <button class="btn btn-primary addChoice" type="button">Add</button>
                                    <button class="btn btn-primary removeChoice" type="button">Remove</button>
                                    <div class="mt-2"></div>
                                    <hr>
                                    <div class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <button id="add-question" class="btn btn-primary" type="button">Add Question</button>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Submit</button>
    {{ Form::close() }}
@stop

@push('scripts')
    <div style="display: none;" id="question">
        <div class="kt-portlet kt-portlet--sortable">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Question
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-group">
                        <button onclick="return false;" role="button" class="btn btn-sm btn-icon btn-success btn-elevate btn-icon-md remove-question-btn"><i class="la la-close"></i></button>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="form-group row">
                    {!! Form::label('name', 'Name', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::text('name[]', '', ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('question', 'Question', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::text('question[]', '', ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('type', 'Type', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::select('type[]', array_combine(\App\Models\ServiceQuestion::TYPES, \App\Models\ServiceQuestion::TYPES), null, ['class' => "form-control type", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('auth_type', 'Auth Type', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::select('auth_type[]', array_combine(\App\Models\ServiceQuestion::AUTH_RULES, \App\Models\ServiceQuestion::AUTH_RULES), null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('is_required', 'Is Required?', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::select('is_required[]', [true => 'yes' , false => 'no'], null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>

                <div class="choices mt-3" style="display: none;">
                    <div class="choice-inputs"></div>

                    <button class="btn btn-primary addChoice" type="button">Add</button>
                    <button class="btn btn-primary removeChoice" type="button">Remove</button>
                    <div class="mt-2"></div>
                    <hr>
                    <div class="mt-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Page Vendors(used by this page) -->
    <script src="assets/plugins/custom/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>

    <script type="text/javascript">

        function fixChoiceInputsIndexes()
        {
            $( ".choice-inputs" ).each(function( index ) {
                $(this).find('input').attr('name', 'choices['+index+'][]');
            });
        }

        var KTPortletDraggable = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $("#kt_sortable_portlets").sortable({
                        connectWith: ".kt-portlet__head",
                        items: ".kt-portlet",
                        opacity: 0.8,
                        handle : '.kt-portlet__head',
                        coneHelperSize: true,
                        placeholder: 'kt-portlet--sortable-placeholder',
                        forcePlaceholderSize: true,
                        tolerance: "pointer",
                        helper: "clone",
                        tolerance: "pointer",
                        forcePlaceholderSize: !0,
                        helper: "clone",
                        cancel: ".kt-portlet--sortable-empty", // cancel dragging if portlet is in fullscreen mode
                        revert: 250, // animation in milliseconds
                        update: function(b, c) {
                            fixChoiceInputsIndexes();

                            if (c.item.prev().hasClass("kt-portlet--sortable-empty")) {
                                c.item.prev().before(c.item);
                            }

                        }
                    });
                }
            };
        }();

        jQuery(document).ready(function() {
            $('#kt_sortable_portlets').on('change', 'select.type', function () {
                if (this.value == '{{\App\Models\ServiceQuestion::TYPE_SELECT}}' ||
                    this.value == '{{\App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE}}') {
                    $(this).parent().parent().parent().find('.choices').show();
                } else {
                    $(this).parent().parent().parent().find('.choices').hide();
                }

                fixChoiceInputsIndexes();
            });

            $('#kt_sortable_portlets').on('click', '.addChoice', function () {
                $(this).parent().find('.choice-inputs').append("<div>" +
                    "<div class=\"form-group\">\n" +
                    "<label>Choice</label>\n" +
                    "<input type=\"text\" name=\"choices[][]\" class=\"form-control\" />\n" +
                    "</div>" +
                    "</div>");

                fixChoiceInputsIndexes();
            });

            $('#kt_sortable_portlets').on('click', '.removeChoice', function () {
                $(this).parent().find('.choice-inputs > div:last-child').remove();
                fixChoiceInputsIndexes();
            });

            $('#kt_sortable_portlets').on('click', '.remove-question-btn', function () {
                $(this).parent().parent().parent().parent().remove();
                fixChoiceInputsIndexes();
                total_questions--;
            });

            $('#add-question').click(function () {
                fixChoiceInputsIndexes();
                $(this).parent().find('#kt_sortable_portlets').append($('#question').html());
            });

            fixChoiceInputsIndexes();
            KTPortletDraggable.init();
        });
    </script>
@endpush
