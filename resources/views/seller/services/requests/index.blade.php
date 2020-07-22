@extends('seller.layouts.dashboard', ['page_title' => "Service Requests"])


@section('breadcrumb')
    <a href="{{ route('seller.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('seller.services.index') }}" class="kt-subheader__breadcrumbs-link">Services</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Service Requests</span>
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
                    Service Requests
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
                                url: '{{route('seller.requests.json')}}',
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
                                var image = 'image';
                                if (row.service_seller && row.service_seller.featured_image)
                                    image = row.service_seller.featured_image;
                                else if (row.service && row.service.featured_image)
                                    image = row.service_seller.featured_image;

                                return '\
                                <img class="img-thumbnail" src="' + (image.replace('public', '/storage')) + '">\
                                ';
                            }
                        }, {
                            field: 'service.name',
                            title: 'Name',
                        }, {
                            field: 'total_amount',
                            title: 'Total Price'
                        }, {
                            field: 'buyer.name',
                            title: 'Buyer Name'
                        }, {
                            field: 'buyer.email',
                            title: 'Buyer Email'
                        }, {
                            field: 'buyer.phone',
                            title: 'Buyer Phone'
                        }, {
                            field: 'shipping_address',
                            title: 'Address'
                        }, {
                            field: 'shipping_location.name',
                            title: 'Area'
                        }, {
                            field: 'shipping_location.city.name',
                            title: 'City'
                        }, {
                            field: 'shipping_location.city.state.name',
                            title: 'State/Province'
                        }, {
                            field: 'buyer.phone',
                            title: 'Buyer Phone'
                        }, {
                            field: 'status',
                            title: 'Status',
                            autoHide: false,
                            template: function (row) {
                                if (row.status === '{{\App\Models\ServiceRequest::STATUS_NEW}}')
                                    return "<p class='text-info'>Waiting for Confirmation.</p>";
                                else if (row.status === '{{\App\Models\ServiceRequest::STATUS_CONFIRMED}}')
                                    return "<p class='text-info'>Service Request Order Confirmed and Waiting for Buyer Confirmation of Completion.</p>";
                                else if (row.status === '{{\App\Models\ServiceRequest::STATUS_CANCELED}}')
                                    return "<p class='text-danger'>Service Request Order Canceled.</p>";
                                else if (row.status === '{{\App\Models\ServiceRequest::STATUS_COMPLETED}}')
                                    return "<p class='text-success'>Service Request Order Completed.</p>";
                                else
                                    return "<p class='text-danger'>Unknown Status!!! Something went wrong!!!!</p>";
                            }
                        }, {
                            field: 'answers',
                            title: 'Answers',
                            width: 500,
                            autoHide: true,
                            template: function (row) {
                                for (var i = 0; i < row.answers.length; i++) {
                                    console.log(row.answers[i]);
                                }

                                var html = "<table class=\"table table-borderless\" align=\"left\">" +
                                    "<thead>" +
                                    "    <tr>" +
                                    "        <th scope=\"col\">#</th>" +
                                    "        <th scope=\"col\">Question</th>" +
                                    "        <th scope=\"col\">Answer</th>" +
                                    "        <th scope=\"col\">Price Change</th>" +
                                    "     </tr>" +
                                    "</thead>" +
                                    "<tbody>";

                                for (var i = 0; i < row.answers.length; i++) {
                                    html +=
                                        "<tr>" +
                                        "    <th scope=\"row\">" + (i + 1) + "</th>" +
                                        "    <td>" + row.answers[i].question + "</td>\n" +
                                        "    <td>";

                                    if (row.answers[i].answer_type == "{{str_replace('\\', '\\\\', \App\Models\ServiceRequestAnswerChoice::class)}}")
                                        html += row.answers[i].answer.choice;
                                    else
                                        html += row.answers[i].answer.answer;

                                    html += "</td><td>";

                                    if (row.answers[i].answer_type == "{{str_replace('\\', '\\\\', \App\Models\ServiceRequestAnswerChoice::class)}}")
                                        html += row.answers[i].answer.price_change;
                                    else
                                        html += "N/A";

                                    html += "</td><td>";
                                }
                                html += "</tbody></table>";

                                return html;
                            }
                        }, {
                            field: 'Actions',
                            title: 'Actions',
                            sortable: false,
                            width: 250,
                            autoHide: false,
                            overflow: 'visible',
                            template: function (row) {
                                if (row.status === '{{\App\Models\ServiceRequest::STATUS_NEW}}')
                                    return "<a href='{{url('/seller/services/requests')}}/" + row.id + "/edit?status=confirm' class='btn btn-outline-primary mr-2'>Confirm</a>" +
                                        "<a href='{{url('/seller/services/requests')}}/" + row.id + "/edit?status=cancel' class='btn btn-outline-danger'>Cancel</a>";
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
