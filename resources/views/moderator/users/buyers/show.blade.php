@extends('moderator.layouts.dashboard', ['page_title' => "Buyers"])

@section('breadcrumb')
    <a href="{{ route('moderator.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('moderator.users.buyers.index') }}" class="kt-subheader__breadcrumbs-link">Buyers</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Buyer Details</span>
@endsection

@section('breadcrumb-elements')

@endsection

@push('styles')

@endpush

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-user"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    Profile Details
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a class="btn btn-brand btn-elevate btn-icon-sm" href="#editModal" data-toggle="modal"
                           data-target="#editModal" data-target="#editModal" data-id="{{$user->id}}"
                           data-name="{{$user->name}}" data-email="{{$user->email}}" data-phone="{{$user->phone}}"
                           data-address="{{$user->address}}" data-location="{{$user->location_id}}">
                            <i class="la la-edit"></i>
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="table-responsive">
                <table class="table table-light table-bordered">
                    <tbody>
                    <tr>
                        <th width="150">Name</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th width="150">Email</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th width="150">Phone</th>
                        <td>{{$user->phone}}</td>
                    </tr>
                    <tr>
                        <th width="150">Address</th>
                        <td>{{$user->address}}</td>
                    </tr>
                    <tr>
                        <th width="150">Area</th>
                        <td>{{$user->location ? $user->location->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">City</th>
                        <td>{{$user->location && $user->location->city ? $user->location->city->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">State</th>
                        <td>{{$user->location && $user->location->city && $user->location->city->state ? $user->location->city->state->name : ''}}</td>
                    </tr>
                    </tbody>
                </table>
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
                    Product Orders
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">

                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div class="kt-datatable" id="product_orders_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>

    @include('moderator.users.buyers.modals.edit')
@endsection

@push('scripts')
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('moderator/users/buyers')}}/" + id);
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
                                url: '{{route('moderator.users.buyers.json')}}',
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
                        <a href="{{url('/moderator/users/buyers')}}/' + row.id + '" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="View Details">\
							<i class="la la-eye"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Edit Details" data-toggle="modal" data-target="#editModal" data-id="' + row.id + '" data-name="' + row.name + '" data-email="' + row.email + '" data-phone="' + row.phone + '" data-address="' + row.address + '" data-location="' + row.location_id + '">\
							<i class="la la-edit"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-sm" title="Delete" data-toggle="modal" data-target="#deleteModal" data-id="' + row.id + '">\
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
