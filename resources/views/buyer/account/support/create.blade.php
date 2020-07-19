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
                <li class="breadcrumb-item" aria-current="page">Account</li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('buyer.account.support.index')}}">Support Tickets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create New</li>
            </ol>
        </div>
    </nav>
@endsection

@section('content')
    <div>
        <h2 class="d-inline">Create Support Ticket</h2>
    </div>

    <div class="mb-4"></div>

    <form action="{{route('buyer.account.support.store')}}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title" class="col-form-label">{{ __('Title') }}</label>
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="message" class="col-form-label">{{ __('Message') }}</label>
            <textarea id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" required autocomplete="message" autofocus></textarea>

            @error('message')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="files" class="col-form-label">{{ __('Files') }}</label>
            <input id="files" type="text" class="form-control @error('files') is-invalid @enderror" name="files" value="{{ old('files') }}">

            @error('files')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                {{ __('Submit') }}
            </button>
        </div>
    </form>
@endsection
