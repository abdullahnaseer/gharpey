@extends('admin.layouts.dashboard', ['page_title' => "Create Service"])

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('admin.services.index') }}" class="kt-subheader__breadcrumbs-link">Services</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Create New</span>
@endsection

@section('breadcrumb-elements')
    <a class="btn btn-brand btn-elevate btn-icon-sm"  href="{{route('admin.services.index')}}" data-toggle="modal" data-target="#createModal">
        <i class="la la-arrow-left"></i>
        Back
    </a>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    @php($i = 0)
    {{ Form::model($service, ['route' => ['admin.services.update', $service->id], 'method' => 'PUT', 'files' => true]) }}
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
                <h3 class="kt-portlet__head-title">
                    Service Information
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="form-group">
                {!! Form::label('name', 'Name', ['class' => "col-form-label"]) !!}
                {!! Form::text('name', null, ['class' => "form-control", "required" => "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('description', 'Description', ['class' => "col-form-label"]) !!}
                {!! Form::textarea('description', null, ['class' => "form-control", "required" => "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('category_id', 'Category', ['class' => "col-form-label"]) !!}
                {!! Form::select('category_id', $categories->pluck('name', 'id'), null, ['class' => "form-control", "required" => "required"]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('featured_image', 'Featured Image', ['class' => "col-form-label"]) !!}
                {!! Form::file('featured_image') !!}
            </div>

        </div>

        <div class="kt-portlet__foot">
            <button class="btn btn-primary" type="submit">Edit</button>
        </div>
    </div>

    {{ Form::close() }}
@stop
