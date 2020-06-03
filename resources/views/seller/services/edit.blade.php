@extends('seller.layouts.dashboard', ['page_title' => 'Edit Service'])

@section('breadcrumb')
    <a href="{{ route('seller.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('seller.services.index') }}" class="kt-subheader__breadcrumbs-link">Services</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Edit</span>
@endsection

@section('breadcrumb-elements')
    <a class="btn btn-brand btn-elevate btn-icon-sm"  href="{{route('seller.services.index')}}">
        <i class="la la-arrow-left"></i>
        Back
    </a>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    @php($i = 0)
    {{ Form::open(['route' => 'seller.services.store', 'method' => 'POST', 'files' => true, 'id' => 'service-form' ,'novalidate']) }}
        @include('seller.services.includes.form')
    {{ Form::close() }}
@stop

@push('modals')
    @include('seller.services.modals.rules')
@endpush

@push('scripts')
    <div style="display: none;" id="question">
        @include('seller.services.includes.question-portlet')
    </div>

    <div style="display: none;" id="choice">
        @include('seller.services.includes.choice-portlet')
    </div>

    <!--begin::Page Vendors(used by this page) -->
    <script src="assets/plugins/custom/jquery-ui/jquery-ui.bundle.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script src="{{url('js/editor.js')}}"></script>

    {{--    <script src="{{url('js/seller-services.js')}}"></script>--}}
    <script type="text/javascript">
        function fixInputsIndexes()
        {
            $('#question_portlets > .kt-portlet').each(function( index ) {
                $(this).find('.input-name').attr('name', 'name['+index+']');
                $(this).find('.input-question').attr('name', 'question['+index+']');
                $(this).find('.select-type').attr('name', 'type['+index+']');
                // $(this).find('.select-required').attr('name', 'is_required['+index+']');
            });
            $( ".choice-portlets").each(function( q_index ) {
                $(this).find('.choice-portlet').each(function( index ) {
                    $(this).find('.choice_text').attr('name', 'choice_text['+q_index+']['+index+']');
                    $(this).find('.choice_price_effect').attr('name', 'choice_price_effect['+q_index+']['+index+']');
                });
            });
        }

        var KTPortletDraggable = function () {

            return {
                //main function to initiate the module
                init: function () {
                    $("#question_portlets").sortable({
                        connectWith: ".question-head",
                        items: ".question-portlet",
                        opacity: 0.875,
                        handle : '.question-head',
                        coneHelperSize: true,
                        placeholder: 'question-placeholder',
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
                            fixInputsIndexes();
                        },
                        change: function(b, c) { fixInputsIndexes(); },
                    });

                    $(".choice-portlets").sortable({
                        connectWith: ".choice-head",
                        items: ".choice-portlet",
                        opacity: 0.75,
                        handle : '.choice-head',
                        coneHelperSize: true,
                        placeholder: 'choice-placeholder',
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
                            fixInputsIndexes();
                        },
                        change: function(b, c) { fixInputsIndexes(); },
                    });
                }
            };
        }();

        jQuery(document).ready(function() {
            $('body').on('click', '.up-question-btn', function() {
                var item = $(this).parent().parent().parent().parent();
                var prev = item.prev();
                if (prev.length == 0)
                    return;
                prev.css('z-index', 999).css('position','relative').animate({ top: item.height() }, 250);
                item.css('z-index', 1000).css('position', 'relative').animate({ top: '-' + prev.height() }, 300, function () {
                    prev.css('z-index', '').css('top', '').css('position', '');
                    item.css('z-index', '').css('top', '').css('position', '');
                    item.insertBefore(prev);
                    fixInputsIndexes();
                });

            });

            $('body').on('click', '.down-question-btn', function() {
                var item = $(this).parent().parent().parent().parent();
                var next = item.next();
                if (next.length == 0)
                    return;
                next.css('z-index', 999).css('position', 'relative').animate({ top: '-' + item.height() }, 250);
                item.css('z-index', 1000).css('position', 'relative').animate({ top: next.height() }, 300, function () {
                    next.css('z-index', '').css('top', '').css('position', '');
                    item.css('z-index', '').css('top', '').css('position', '');
                    item.insertAfter(next);
                    fixInputsIndexes();
                });

            });

            $('.select2-js').select2({
                closeOnSelect: true
            });

            $('.select2-js-multiple').select2({
                closeOnSelect: false
            });

            function hideAllQuestionDetailSections(elem)
            {
                hideQuestionDetailSection(elem, '.boolean-price-effect');
                hideQuestionDetailSection(elem, '.choices-container');
            }

            function hideQuestionDetailSection(elem, section)
            {
                $(elem).parent().parent().parent().parent().find(section).hide();
            }

            function showQuestionDetailSection(elem, section)
            {
                $(elem).parent().parent().parent().parent().find(section).show();
            }

            $('body').on('click', '.remove-question-btn', function () {
                $(this).parent().parent().parent().parent().remove();
            });

            $('#add-question').click(function () {
                $(this).parent().find('#question_portlets').append($('#question').html());
                fixInputsIndexes();
                $('#question_portlets .choices-select').select2({
                    tags: true,
                    width: '100%'
                });
            });

            $('#question_portlets').on('click', '.btn-add-choice', function () {
                $(this).parent().find('.choice-portlets').append($('#choice').html());
            });

            $('#question_portlets').on('change', '.select-type', function () {
                hideAllQuestionDetailSections(this);

                if (this.value === "{{ str_replace("\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeSelect::class) }}"
                    || this.value === "{{ str_replace("\\", "\\\\", \App\Helpers\ServiceQuestionType\ServiceQuestionTypeSelectMultiple::class) }}")
                    showQuestionDetailSection(this, '.choices-container');
            });

            $("#question_portlets .choices-select").each(function() {
                $(this).select2({tags: true});
            });

            $( "#service-form" ).submit(function( event ) {
                fixInputsIndexes();
                // $(this)
            });

            KTPortletDraggable.init();
        });
    </script>
@endpush
