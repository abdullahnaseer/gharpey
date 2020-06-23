@extends('admin.layouts.dashboard', ['page_title' => "Dashboard"])

@section('breadcrumb')
    <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
    <span class="breadcrumb-item active">Dashboard</span>
@endsection

@section('content')
    <div class="alert alert-primary">Welcome to Admin Panel!</div>

    <div class="row">
        @include('shared.charts.chart', ['col-sm-6'])
    </div>
@endsection

@push('scripts')
    @include('shared.charts.script')
@endpush
