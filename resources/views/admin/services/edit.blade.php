@extends('admin.layouts.dashboard', ['page_title' => "Create Service"])

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    @php($i = 0)
    {{ Form::model($service, ['route' => ['admin.services.update', $service->id], 'method' => 'PUT', 'files' => true]) }}
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
                                {!! Form::hidden('question_id[]', null, ['class' => 'question_id']) !!}
                                <div class="form-group row">
                                    {!! Form::label('title', 'Title', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('title['.$loop->index.']', old('question.'.$loop->index), ['class' => "form-control input-title", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('question', 'Question', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('question['.$loop->index.']', old('question.'.$loop->index), ['class' => "form-control input-question", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('type', 'Type', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('type['.$loop->index.']', array_combine(\App\Models\ServiceQuestion::TYPES, \App\Models\ServiceQuestion::TYPES), $question, ['class' => "form-control type select-type", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('auth_type', 'Auth Type', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('auth_type['.$loop->index.']', array_combine(\App\Models\ServiceQuestion::AUTH_RULES, \App\Models\ServiceQuestion::AUTH_RULES), old('auth_type.'.$loop->index), ['class' => "form-control select-auth-type", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('is_required', 'Is Required?', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('is_required['.$loop->index.']', [true => 'yes' , false => 'no'], old('is_required.'.$loop->index), ['class' => "form-control select-required", "required" => "required"]) !!}
                                    </div>
                                </div>

                                <div class="choices form-group row" style="display: {{ ($question === \App\Models\ServiceQuestion::TYPE_SELECT || $question === \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE) ? "block" : "none" }};">
                                    {!! Form::label('choices', 'Choices', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        @php($c = old('choices.'.$loop->index, []))
                                        {!! Form::select('choices['.$loop->index.'][]', array_combine($c, $c), $c, ['class' => "form-control choices-select", "multiple" => "multiple"]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach($service->questions as $question)
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
                                {!! Form::hidden('question_id[]', $question->id, ['class' => 'question_id']) !!}
                                <div class="form-group row">
                                    {!! Form::label('title', 'Title', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('title['.$loop->index.']', $question->title, ['class' => "form-control input-title", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('question', 'Question', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('question['.$loop->index.']', $question->question, ['class' => "form-control input-question", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('type', 'Type', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('type['.$loop->index.']', array_combine(\App\Models\ServiceQuestion::TYPES, \App\Models\ServiceQuestion::TYPES), $question->type, ['class' => "form-control type select-type", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('auth_type', 'Auth Type', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('auth_type['.$loop->index.']', array_combine(\App\Models\ServiceQuestion::AUTH_RULES, \App\Models\ServiceQuestion::AUTH_RULES), $question->auth_rule, ['class' => "form-control select-auth-type", "required" => "required"]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('is_required', 'Is Required?', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('is_required['.$loop->index.']', [true => 'yes' , false => 'no'], $question->is_required, ['class' => "form-control select-required", "required" => "required"]) !!}
                                    </div>
                                </div>

                                <div class="choices form-group row" style="display: {{ ($question->type === \App\Models\ServiceQuestion::TYPE_SELECT || $question->type === \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE) ? "block" : "none" }};">
                                    {!! Form::label('choices', 'Choices', ['class' => "col-form-label col-md-3"]) !!}
                                    <div class="col-md-9">
                                        @if($question->type === \App\Models\ServiceQuestion::TYPE_SELECT || $question->type === \App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE)
                                            @php($c = $question->choices->pluck('choice', 'choice'))
                                            {!! Form::select('choices['.$loop->index.'][]', $c, $question->choices->pluck('choice'), ['class' => "form-control choices-select", "multiple" => "multiple"]) !!}
                                        @else
                                            {!! Form::select('choices['.$loop->index.'][]', [], [], ['class' => "form-control choices-select", "multiple" => "multiple"]) !!}
                                        @endif
                                    </div>
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
                {!! Form::hidden('question_id[]', null, ['class' => 'question_id']) !!}
                <div class="form-group row">
                    {!! Form::label('title', 'Title', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::text('title[]', '', ['class' => "form-control input-title", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('question', 'Question', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::text('question[]', '', ['class' => "form-control input-question", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('type', 'Type', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::select('type[]', array_combine(\App\Models\ServiceQuestion::TYPES, \App\Models\ServiceQuestion::TYPES), null, ['class' => "form-control type select-type", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="row">
                            {!! Form::label('auth_type', 'Auth Type', ['class' => "col-form-label col-sm-3 col-md-6"]) !!}
                            <div class="col-sm-9 col-md-6">
                                {!! Form::select('auth_type[]', array_combine(\App\Models\ServiceQuestion::AUTH_RULES, \App\Models\ServiceQuestion::AUTH_RULES), null, ['class' => "form-control select-auth-type", "required" => "required"]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="row">
                            {!! Form::label('is_required', 'Is Required?', ['class' => "col-form-label col-sm-3 col-md-6"]) !!}
                            <div class="col-sm-9 col-md-6">
                                {!! Form::select('is_required[]', [true => 'yes' , false => 'no'], null, ['class' => "form-control select-required", "required" => "required"]) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="choices form-group row" style="display: none;">
                    {!! Form::label('choices', 'Choices', ['class' => "col-form-label col-md-3"]) !!}
                    <div class="col-md-9">
                        {!! Form::select('choices[][]', [], null, ['class' => "form-control choices-select", "multiple" => "multiple"]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::Page Vendors(used by this page) -->
    <script src="assets/plugins/custom/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        function fixChoiceInputsIndexes()
        {
            $('#kt_sortable_portlets > .kt-portlet').each(function( index ) {
                $(this).find('.question_id').attr('name', 'question_id['+index+']');
                $(this).find('.input-title').attr('name', 'title['+index+']');
                $(this).find('.input-question').attr('name', 'question['+index+']');
                $(this).find('.select-type').attr('name', 'type['+index+']');
                $(this).find('.select-auth-type').attr('name', 'auth_type['+index+']');
                $(this).find('.select-required').attr('name', 'is_required['+index+']');
            });
            $( ".choices" ).each(function( index ) {
                $(this).find('.choices-select').attr('name', 'choices['+index+'][]');
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
                            if (c.item.prev().hasClass("kt-portlet--sortable-empty")) {
                                c.item.prev().before(c.item);
                            }
                            fixChoiceInputsIndexes();
                        }
                    });
                }
            };
        }();

        jQuery(document).ready(function() {
            $('#kt_sortable_portlets').on('change', 'select.type', function () {
                if (this.value == '{{\App\Models\ServiceQuestion::TYPE_SELECT}}' ||
                    this.value == '{{\App\Models\ServiceQuestion::TYPE_SELECT_MULTIPLE}}') {
                    $(this).parent().parent().parent().parent().find('.choices').show();

                } else {
                    $(this).parent().parent().parent().parent().find('.choices').hide();
                }
                fixChoiceInputsIndexes();
            });

            $('#kt_sortable_portlets').on('click', '.remove-question-btn', function () {
                $(this).parent().parent().parent().parent().remove();
                fixChoiceInputsIndexes();
            });

            $('#add-question').click(function () {
                $(this).parent().find('#kt_sortable_portlets').append($('#question').html());
                fixChoiceInputsIndexes();
                $('#kt_sortable_portlets .choices-select').select2({
                    tags: true,
                    width: '100%'
                });
            });

            $("#kt_sortable_portlets .choices-select").each(function() {
                $(this).select2({tags: true});
            });

            KTPortletDraggable.init();
            fixChoiceInputsIndexes();
        });
    </script>
@endpush
