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
                <li class="breadcrumb-item active" aria-current="page">Ticket#{{$ticket->id}}</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <div>
        <h2 class="d-inline">Support Ticket#{{$ticket->id}}</h2>
    </div>

    <div class="mb-4"></div>

    @if($ticket->messages->count())
        @foreach($ticket->messages as $message)
            <div>
                <p>
                    {{$message->message}}
                    <br>
                    <small>{{$message->created_at->diffForHumans()}}</small>
                </p>
                <hr class="my-1">
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No messages found!
        </div>
    @endif
@endsection
