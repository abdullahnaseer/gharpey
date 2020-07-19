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
                <li class="breadcrumb-item active" aria-current="page">Support Tickets</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <div>
        <h2 class="d-inline">Support Tickets</h2>
        <a href="{{route('buyer.account.support.create')}}" class="btn btn-sm btn-outline-dark">Create New</a>
    </div>

    <div class="mb-4"></div>

    @if($tickets->count())
        @foreach($tickets as $ticket)
            <div>
                <p>
                    {{$ticket->title}}
                    <br>
                    <small>{{$ticket->created_at->diffForHumans()}}</small>
                </p>
                <hr class="my-1">
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No support tickets found!
        </div>
    @endif
@endsection
