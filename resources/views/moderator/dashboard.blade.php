@extends('moderator.layouts.dashboard', ['page_title' => "Dashboard"])

@section('breadcrumb')
    <a href="{{url('/moderator')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
    <span class="breadcrumb-item active">Dashboard</span>
@endsection

@section('content')
    <div class="alert alert-info">You are logged-in as moderator.</div>
@endsection
