@extends('moderator.layouts.dashboard', ['page_title' => "Buyers"])

@section('breadcrumb')
    <a href="{{ auth('moderator')->check() ? route('moderator.dashboard') : route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('moderator.users.buyers.index') }}" class="kt-subheader__breadcrumbs-link">Sellers</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Seller Details</span>
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
                        <a href="#editModal" class="btn btn-brand btn-elevate btn-icon-sm" title="Edit details" data-toggle="modal" data-target="#editModal" \
                           data-id="{{$user->id}}"
                           data-shop-name="{{$user->shop_name}}"
                           data-name="{{$user->name}}"
                           data-email="{{$user->email}}"
                           data-phone="{{$user->phone}}"
                           data-cnic="{{$user->cnic}}"
                           data-business_address="{{$user->business_address}}"
                           data-business_location="{{$user->business_location_id}}"
                           data-warehouse_address="{{$user->warehouse_address}}"
                           data-warehouse_location="{{$user->warehouse_location_id}}"
                           data-return_address="{{$user->return_address}}"
                           data-return_location="{{$user->return_location_id}}">

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
                        <th width="150">Shop Name</th>
                        <td>{{$user->shop_name}}</td>
                    </tr>
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
                        <th width="150">Warehouse Address</th>
                        <td>{{$user->warehouse_address}}</td>
                    </tr>
                    <tr>
                        <th width="150">Warehouse Address Area</th>
                        <td>{{$user->warehouse_location ? $user->warehouse_location->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Warehouse Address City</th>
                        <td>{{$user->warehouse_location && $user->warehouse_location->city ? $user->warehouse_location->city->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Warehouse Address State</th>
                        <td>{{$user->warehouse_location && $user->warehouse_location->city && $user->warehouse_location->city->state ? $user->warehouse_location->city->state->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Business Address</th>
                        <td>{{$user->business_address}}</td>
                    </tr>
                    <tr>
                        <th width="150">Business Address Area</th>
                        <td>{{$user->business_location ? $user->business_location->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Business Address City</th>
                        <td>{{$user->business_location && $user->business_location->city ? $user->business_location->city->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Business Address State</th>
                        <td>{{$user->business_location && $user->business_location->city && $user->business_location->city->state ? $user->business_location->city->state->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Return Address</th>
                        <td>{{$user->return_address}}</td>
                    </tr>
                    <tr>
                        <th width="150">Return Address Area</th>
                        <td>{{$user->return_location ? $user->return_location->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Return Address City</th>
                        <td>{{$user->return_location && $user->return_location->city ? $user->return_location->city->name : ''}}</td>
                    </tr>
                    <tr>
                        <th width="150">Return Address State</th>
                        <td>{{$user->return_location && $user->return_location->city && $user->return_location->city->state ? $user->return_location->city->state->name : ''}}</td>
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
                    Products
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
            <div class="kt-datatable" id="products_datatable"></div>
            <!--end: Datatable -->
        </div>
    </div>


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

                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div class="kt-datatable" id="services_datatable"></div>
            <!--end: Datatable -->
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
    @include('moderator.users.sellers.modals.edit')
@endsection

@push('scripts')
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('moderator/users/sellers')}}/" + id);
            modal.find('form input#shop_name').val(button.data('shop-name'));
            modal.find('form input#cnic').val(button.data('cnic'));
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

        var KTDatatableJsonRemoteProducts = function () {
            var jsonResource = function () {
                var datatable = $('#products_datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('moderator.products.json', ['seller_id' => $user->id])}}',
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
                                <img class="img-thumbnail" src="' + (row.featured_image ? row.featured_image.replace('public', '/storage') : '') + '">\
                                ';
                            }
                        }, {
                            field: 'name',
                            title: 'Name',
                        }, {
                            field: 'slug',
                            title: 'Slug',
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 150,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
                                return "No Action Available."
                                // return '\
                                //     <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Show Product Detail">\
                                //         <i class="la la-eye"></i>\
                                //     </a>\
                                // ';
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

        var KTDatatableJsonRemoteServices = function () {
            var jsonResource = function () {
                var datatable = $('#services_datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('moderator.service_sellers.json', ['seller_id' => $user->id])}}',
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
                                <img class="img-thumbnail" src="' + (row.featured_image.replace('public', '/storage')) + '">\
                                ';
                            }
                        }, {
                            field: 'service.name',
                            title: 'Service Name',
                        }, {
                            field: 'price',
                            title: 'Total Price'
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 250,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
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

        var KTDatatableJsonRemoteProductOrders = function () {
            var jsonResource = function () {
                var datatable = $('#product_orders_datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('moderator.orders.json', ['seller_id' => $user->id])}}',
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
                            field: 'order.buyer',
                            title: 'Buyer',
                            template: function (row) {
                                return '\
                                    <a href="/moderator/users/buyers/'+row.order.buyer.id+'">'+row.order.buyer.name+'</a>\
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
            KTDatatableJsonRemoteProducts.init();
            KTDatatableJsonRemoteServices.init();
            KTDatatableJsonRemoteProductOrders.init();
        });
    </script>
@endpush
