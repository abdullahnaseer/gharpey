@extends('seller.layouts.dashboard')

@section('content')
    <div class="row">
        @include('shared.charts.chart')
    </div>
@endsection

@push('scripts')
    @include('shared.charts.script')
@endpush
