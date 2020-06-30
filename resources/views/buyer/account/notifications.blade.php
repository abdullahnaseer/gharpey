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
                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <h2>Notifications</h2>

    <div class="mb-4"></div>
    <!-- margin -->

    @if($notifications->count())
        @foreach($notifications as $notification)
            <div>
                <p>
                    {{$notification->data['message']}}
                    <br>
                    <small>{{$notification->created_at->diffForHumans()}}</small>
                </p>
                <hr class="my-1">
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No notification found. <a href="{{route('buyer.products.index')}}">Continue Shopping!</a>
        </div>
    @endif
@endsection
