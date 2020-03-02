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
                <li class="breadcrumb-item active" aria-current="page">Account Wishlist</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h2>My Orders</h2>

    <div class="mb-4"></div>
    <!-- margin -->

    @if($products->count())
        @foreach($products as $product)
            <div>{{$product->name}}</div>
        @endforeach
    @else
        <div class="alert alert-info">
            No items found in your wishlist. <a href="{{route('buyer.products.index')}}">Continue Shopping!</a>
        </div>
    @endif
@endsection
