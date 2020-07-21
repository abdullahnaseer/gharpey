@extends('moderator.layouts.dashboard', ['page_title' => "Product Orders"])

@section('breadcrumb')
    <a href="{{ auth('moderator')->check() ? route('moderator.dashboard') : route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('moderator.products.index') }}" class="kt-subheader__breadcrumbs-link">Products</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Orders</span>
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
                    Product Orders
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit">
            <!--begin: Datatable -->
            <div class="kt-datatable" id="json_data"></div>
            <!--end: Datatable -->
        </div>
    </div>
@stop

{{--@push('modals')--}}
{{--    @include('seller.products.modals.create', ['categories' => $categories])--}}
{{--    @include('seller.products.modals.edit')--}}
{{--    @include('seller.products.modals.delete')--}}
{{--@endpush--}}

@push('scripts')
    <script>
        var KTDatatableJsonRemote = function () {
            var jsonResource = function () {
                var datatable = $('.kt-datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'remote',
                        source: {
                            read: {
                                url: '{{route('moderator.orders.json')}}',
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
                        scroll: true, // enable/disable datatable scroll both horizontal and vertical when needed.
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
