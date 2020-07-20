@extends('moderator.layouts.app' )

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-3">
            <a href="{{route('moderator.login')}}" class="btn btn-primary col-md-8">Login</a>
        </div>
    </div>
@endsection
