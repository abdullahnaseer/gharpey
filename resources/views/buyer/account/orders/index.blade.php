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
                                    @endif
                                    @if(is_null($item->reviewed_at))
                                        <a href="#">Write a Review </a>
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
@endsection
