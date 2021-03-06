@extends('moderator.layouts.dashboard', ['page_title' => "Buyers"])

@section('breadcrumb')
    <a href="{{ auth('moderator')->check() ? route('moderator.dashboard') : route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
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
                var datatable = $('#product_orders_datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('moderator.orders.json', ['buyer_id' => $user->id])}}',
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
                            field: 'product.featured_image',
                            title: 'Image',
                            sortable: false,
                            width: 100,
                            template: function (row) {
                                return '\
                                <img class="img-thumbnail" src="' + (row.product && row.product.featured_image ? row.product.featured_image.replace('public', '/storage') : '') + '">\
                                ';
                            }
                        }, {
                            field: 'product.name',
                            title: 'Name',
                        }, {
                            field: 'price',
                            title: 'Total Price'
                        }, {
                            field: 'quantity',
                            title: 'Quantity',
                        }, {
                            field: 'product.seller',
                            title: 'Seller',
                            template: function (row) {
                                return '\
                                    <a href="/moderator/users/sellers/'+row.product.seller.id+'">'+row.product.seller.shop_name+'</a>\
                                ';
                            },
                        }, {
                            field: 'status',
                            title: 'Status',
                            autoHide: false,
                            template: function (row) {
                                if (row.status == '{{\App\Models\ProductOrder::STATUS_NEW}}')
                                    return "<p class='text-danger'>Waiting for confirmation by seller.</p>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_CONFIRMED}}')
                                    return "<p class='text-danger'>Order Confirmed and Waiting for delivery by seller.</p>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_SELLER_SENT}}')
                                    return "<p class='text-info'>Waiting for arrival of product at our warehouse.</p>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_WAREHOUSE_RECEVIED}}')
                                    return "<p class='text-success'>Product received at warehouse and is in processing phase.</p>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_SENT}}')
                                    return "<p class='text-info'>In delivery phase to buyer.</p>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_CANCELED}}')
                                    return "<p class='text-danger'>Order Canceled</p>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_COMPLETED}}')
                                    return "<p class='text-success'>Order Completed</p>";
                                else
                                    return "<p class='text-danger'>Unknown Status!!! Something went wrong!!!!</p>";
                            }
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 250,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
                                if (row.status == '{{\App\Models\ProductOrder::STATUS_NEW}}' || row.status == '{{\App\Models\ProductOrder::STATUS_SELLER_SENT}}')
                                    return "<a href='{{url('/moderator/products/orders')}}/" + row.id + "/edit?status=received' class='btn btn-outline-primary mr-2'>Mark Received</a>" +
                                        "<a href='{{url('/moderator/products/orders')}}/" + row.id + "/edit?status=cancel' class='btn btn-outline-danger'>Cancel</a>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_WAREHOUSE_RECEVIED}}')
                                    return "<a href='{{url('/moderator/products/orders')}}/" + row.id + "/edit?status=sent' class='btn btn-outline-primary mr-2'>Mark Sent</a>" +
                                        "<a href='{{url('/moderator/products/orders')}}/" + row.id + "/edit?status=cancel' class='btn btn-outline-danger'>Cancel</a>";
                                else if (row.status == '{{\App\Models\ProductOrder::STATUS_SENT}}')
                                    return "<a href='{{url('/moderator/products/orders')}}/" + row.id + "/edit?status=completed' class='btn btn-outline-primary mr-2'>Mark Completed</a>" +
                                        "<a href='{{url('/moderator/products/orders')}}/" + row.id + "/edit?status=cancel' class='btn btn-outline-danger'>Cancel</a>";
                                else
                                    return "No Action Available";
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
