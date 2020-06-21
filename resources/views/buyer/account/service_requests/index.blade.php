@extends('buyer.layouts.dashboard.dashboard')

@section('styles')
    <style>
        @media screen and (max-width: 786px) {
            .table tr {
                display: flex;
                flex-direction: column;
                justify-items: center;
                margin: auto 0;
                align-content: center;
            }
        }
    </style>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Account</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h2>My Orders</h2>

    <div class="mb-4"></div>
    <!-- margin -->

    @if($service_requests->count())
        @foreach($service_requests as $service_request)
            <div class="card">
                <div class="card-header">
                    Service Request #{{$service_request->id}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" align="left">
                            <tbody>
                                <tr>
                                <td width="100"><img class="img-fluid" src="{{str_replace("public","/storage",$service_request->service_seller->featured_image)}}" alt=""></td>
                                <td width="250">{{$service_request->service->name}}</td>
                                <td width="150">Price Sum: {{$service_request->total_amount}}</td>
                                <td width="100">
                                    @if($service_request->status == \App\Models\ServiceRequest::STATUS_COMPLETED)
                                        <p>
                                            <span class="badge badge-success">Completed</span>
                                        @if(is_null($service_request->reviewed_at))
                                            <span class="badge badge-info">Review Pending</span>
                                        @else
                                            <span class="badge badge-success">Reviewed</span>
                                        @endif
                                        </p>
                                    @elseif($service_request->status == \App\Models\ServiceRequest::STATUS_CANCELED)
                                        <p><span class="badge badge-danger">Cancelled</span></p>
                                    @elseif($service_request->status == \App\Models\ServiceRequest::STATUS_DISPUTED)
                                        <p><span class="badge badge-danger">Disputed</span></p>
                                    @elseif($service_request->status == \App\Models\ServiceRequest::STATUS_CONFIRMED)
                                        <p><span class="badge badge-info">Confirmed</span></p>
                                    @elseif($service_request->status == \App\Models\ServiceRequest::STATUS_NEW)
                                        <p><span class="badge badge-info">New Request</span></p>
                                    @else
                                        <p><span class="badge badge-info">{{$service_request->status}}</span></p>
                                    @endif
                                </td>
                                <td width="200">
                                    Order Placed On: {{ $service_request->created_at->toDateString() }}<br>
                                    @if($service_request->status == \App\Models\ServiceRequest::STATUS_COMPLETED)
                                        Completed On: {{ $service_request->completed_at->toDateString() }}<br>
                                        @if(is_null($service_request->reviewed_at))
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#reviewModal" data-id="{{$service_request->id}}">Write a Review </button>
                                        @else
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showReviewModal" data-id="{{$service_request->id}}" data-rating="{{$service_request->review->rating}}" data-review="{{$service_request->review->review}}">View Review </button>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        @include('buyer.account.orders.modals.review')
        @include('buyer.account.orders.modals.showReview')
    @else
        <div class="alert alert-info">
            No Service Requests found. <a href="{{route('buyer.services.index')}}">Continue Shopping!</a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        $('#reviewModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', "{{url('/account/service-requests')}}/" + id + "/reviews" );
        });

        $('#showReviewModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var review = button.data('review'); // Extract info from data-* attributes
            var rating = button.data('rating'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('#show-rating').html(rating);
            modal.find('#show-review').html(review);
        });
    </script>
@endsection
