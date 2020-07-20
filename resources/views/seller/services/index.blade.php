@extends('seller.layouts.dashboard', ['page_title' => "Services"])

@section('breadcrumb')
    <a href="{{ route('seller.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Services</span>
@endsection

@section('breadcrumb-elements')
    <div class="kt-input-icon kt-input-icon--left">
        <input type="text" class="form-control" placeholder="Search..." id="generalSearch">
        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                            <span><i class="la la-search"></i></span>
                                        </span>
    </div>
@endsection

@push('styles')

@endpush

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
                <h3 class="kt-portlet__head-title">
                    Services
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        {{--                            <a class="btn btn-brand btn-elevate btn-icon-sm"  href="#createModal" data-toggle="modal" data-target="#createModal">--}}
                        {{--                                <i class="la la-plus"></i>--}}
                        {{--                                New Service--}}
                        {{--                            </a>--}}
                        <a class="btn btn-brand btn-elevate btn-icon-sm" href="{{route('seller.services.create')}}">
                            <i class="la la-plus"></i>
                            New Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div class="kt-datatable" id="json_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
@stop

@push('modals')
    @include('seller.services.modals.delete')
@endpush

@push('scripts')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-footer form').attr('action', "{{url('seller/services')}}/" + id);
        });

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('seller/services')}}/" + id);
            modal.find('form input#name').val(button.data('name'));
            modal.find('form input#price').val(button.data('price'));
            modal.find('form textarea#description').val(button.data('description'));
            modal.find('form select#category_id').val(button.data('category'));

            console.log(button.data('cities'));

            var values = "" + button.data('cities');
            $.each(values.split(","), function (i, e) {
                modal.find("form select#cities option[value='" + e + "']").prop("selected", true);
            });
        });

        var KTDatatableJsonRemote = function () {
            var jsonResource = function () {
                var datatable = $('.kt-datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('seller.services.json')}}',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                                }
                            }
                        },
                        pageSize: 10,
                    },

                    // layout definition
                    layout: {
                        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                        footer: false // display/hide footer
                    },

                    // column sorting
                    sortable: true,

                    pagination: true,

                    search: {
                        input: $('#generalSearch')
                    },

                    // columns definition
                    columns: [
                        {
                            field: 'id',
                            title: '#',
                            width: 20,
                            type: 'number',
                            textAlign: 'center',
                        }, {
                            field: 'featured_image',
                            title: 'Image',
                            sortable: false,
                            width: 100,
                            template: function (row) {
                                return '\
                                <img class="img-thumbnail" src="' + (row.pivot && row.pivot.featured_image ? row.pivot.featured_image.replace('public', '/storage') : '') + '">\
                                ';
                            }
                        }, {
                            field: 'name',
                            title: 'Name',
                        }, {
                            field: 'slug',
                            title: 'Slug',
                        }, {
                            field: 'pivot.price',
                            title: 'Price',
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 150,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
                                return '\
						<a href="/seller/services/' + row.id + '/edit" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete" data-toggle="modal" data-target="#deleteModal" data-id="' + row.id + '">\
							<i class="la la-trash"></i>\
						</a>\
					';
                            },
                        }],

                });

                $('#kt_form_status').on('change', function () {
                    datatable.search($(this).val().toLowerCase(), 'Status');
                });

                $('#kt_form_type').on('change', function () {
                    datatable.search($(this).val().toLowerCase(), 'Type');
                });

                $('#kt_form_status,#kt_form_type').selectpicker();

            };

            return {
                // public functions
                init: function () {
                    jsonResource();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTDatatableJsonRemote.init();
        });
    </script>
@endpush
