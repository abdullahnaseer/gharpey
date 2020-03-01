@extends('admin.layouts.dashboard', ['page_title' => "Sellers"])

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Sellers</span>
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
                    Sellers
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a class="btn btn-brand btn-elevate btn-icon-sm"  href="#createModal" data-toggle="modal" data-target="#createModal">
                            <i class="la la-plus"></i>
                            New Seller
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
    @include('admin.users.sellers.modals.create')
    @include('admin.users.sellers.modals.edit')
    @include('admin.users.sellers.modals.delete')
@endpush

@push('scripts')
    <script>
        $('.kt-select2').select2();

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-footer form').attr('action', "{{url('admin/users/sellers')}}/" + id);
        });

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('admin/users/sellers')}}/" + id);
            modal.find('form input#name').val(button.data('name'));
            modal.find('form input#email').val(button.data('email'));
            modal.find('form input#phone').val(button.data('phone'));
            modal.find('form input#warehouse_address').val(button.data('warehouse_address'));
            modal.find('form input#business_address').val(button.data('business_address'));
            modal.find('form input#return_address').val(button.data('return_address'));

            $('#warehouse_location_select2_edit').val(button.data('warehouse_location'));
            $('#warehouse_location_select2_edit').trigger('change'); // Notify any JS components that the value changed

            $('#business_location_select2_edit').val(button.data('business_location'));
            $('#business_location_select2_edit').trigger('change'); // Notify any JS components that the value changed

            $('#return_location_select2_edit').val(button.data('return_location'));
            $('#return_location_select2_edit').trigger('change'); // Notify any JS components that the value changed
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
                                url: '{{route('admin.users.sellers.json')}}',
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
                            field: 'cnic',
                            title: 'CNIC',
                        },  {
                            field: 'warehouse_address',
                            title: 'Warehouse Address',
                        }, {
                            field: 'warehouse_location.name',
                            title: 'Warehouse Location',
                        }, {
                            field: 'warehouse_location.city.name',
                            title: 'Warehouse Location City',
                        }, {
                            field: 'business_address',
                            title: 'Business Address',
                        }, {
                            field: 'business_location.name',
                            title: 'Business Location',
                        }, {
                            field: 'business_location.city.name',
                            title: 'Business Location City',
                        }, {
                            field: 'return_address',
                            title: 'Return Address',
                        }, {
                            field: 'return_location.name',
                            title: 'Return Location',
                        }, {
                            field: 'return_location.city.name',
                            title: 'Return Location City',
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 150,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
                                return '\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details" data-toggle="modal" data-target="#editModal" \
						    data-id="' + row.id + '" ' +
                                    'data-name="' + row.name + '" ' +
                                    'data-email="' + row.email + '" ' +
                                    'data-phone="' + row.phone + '" ' +
                                    'data-business_address="' + row.business_address + '" ' +
                                    'data-business_location="' + row.business_location_id + '" ' +
                                    'data-warehouse_address="' + row.warehouse_address + '" ' +
                                    'data-warehouse_location="' + row.warehouse_location_id + '" ' +
                                    'data-return_address="' + row.return_address + '" ' +
                                    'data-return_location="' + row.return_location_id + '"\
                                    >\
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
