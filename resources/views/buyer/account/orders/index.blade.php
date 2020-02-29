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

    @if($orders->count())
        @foreach($orders as $order)
            <div class="card">
                <div class="card-header">
                    Order #{{$order->id}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless" align="left">
                            <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td width="100"><img class="img-fluid" src="{{str_replace("public","/storage",$item->product->featured_image)}}" alt=""></td>
                                    <td width="250">{{$item->product->name}}</td>
                                    <td width="150">Price Sum: {{$item->price}}<br>Qty:{{ $item->quantity }}</td>
                                    <td width="100">
                                        @if($item->status == \App\Models\ProductOrder::STATUS_COMPLETED)
                                            <p><span class="badge badge-success">{{$item->status}}</span></p>
                                        @elseif($item->status == \App\Models\ProductOrder::STATUS_CANCELED)
                                            <p><span class="badge badge-danger">{{$item->status}}</span></p>
                                        @else
                                            <p><span class="badge badge-secondary">{{$item->status}}</span></p>
                                        @endif
                                    </td>
                                    <td width="200">
                                        Placed On: {{ $item->created_at->toDateString() }}<br>
                                        @if($item->status == \App\Models\ProductOrder::STATUS_COMPLETED)
                                            Delivered On: {{ $item->completed_at->toDateString() }}<br>
                                            @if(is_null($item->reviewed_at))
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#reviewModal" data-id="{{$item->id}}">Write a Review </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        @include('buyer.account.orders.modals.review')
    @else
        <div class="alert alert-info">
            No orders found. <a href="{{route('buyer.products.index')}}">Continue Shopping!</a>
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
            console.log(id);
            modal.find('form').attr('action', "{{url('/account/orders')}}/" + id + "/reviews" );
        });
    </script>
@endsection
