@extends('admin.layouts.dashboard', ['page_title' => "Buyers"])

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Buyers</span>
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
                    Records
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a class="btn btn-brand btn-elevate btn-icon-sm" href="#createModal" data-toggle="modal"
                           data-target="#createModal">
                            <i class="la la-plus"></i>
                            New Record
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
    @include('admin.users.buyers.modals.create')
    @include('admin.users.buyers.modals.edit')
    @include('admin.users.buyers.modals.delete')
@endpush

@push('scripts')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-footer form').attr('action', "{{url('admin/users/buyers')}}/" + id);
        });

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('admin/users/buyers')}}/" + id);
            modal.find('form input#name').val(button.data('name'));
            modal.find('form input#email').val(button.data('email'));
            modal.find('form input#phone').val(button.data('phone'));
            modal.find('form input#address').val(button.data('address'));

            $('#location_select2_edit').val(button.data('location'));
            $('#location_select2_edit').trigger('change'); // Notify any JS components that the value changed
        });

        // nested
        $('#location_select2_create, #location_select2_edit').select2({
            placeholder: "Select a Location"
        });

        var KTDatatableJsonRemote = function () {
            var jsonResource = function () {
                var datatable = $('.kt-datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('admin.users.buyers.json')}}',
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
                            field: 'name',
                            title: 'Name',
                        }, {
                            field: 'email',
                            title: 'Email',
                        }, {
                            field: 'phone',
                            title: 'Phone',
                        }, {
                            field: 'address',
                            title: 'Address',
                        }, {
                            field: 'location.name',
                            title: 'Location',
                        }, {
                            field: 'location.city.name',
                            title: 'City',
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 150,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
                                return '\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details" data-toggle="modal" data-target="#editModal" data-id="' + row.id + '" data-name="' + row.name + '" data-email="' + row.email + '" data-phone="' + row.phone + '" data-address="' + row.address + '" data-location="' + row.location_id + '">\
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
