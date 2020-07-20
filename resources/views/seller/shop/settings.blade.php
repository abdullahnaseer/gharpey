@extends('seller.layouts.dashboard', ['page_title' => "Shop Settings"])

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">Dashboard</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link active">Shop Settings</span>
@endsection

@section('breadcrumb-elements')
@endsection

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
                <h3 class="kt-portlet__head-title">
                    Shop Settings
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
            {{ Form::model($user, ['route' => 'seller.account.updateShop', 'files'=>true, 'class' => 'kt-form kt-form--fit kt-form--label-right']) }}

            <div class="form-group row">
                {!! Form::label('shop_image', 'Shop Image', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                <div class="col-lg-9 col-md-9 col-sm-12">
                    {!! Form::file('shop_image', ['id' => 'shop_image_input']) !!}

                    <div style="max-width: 600px" class="mt-2">
                        <img id="shop_image" class="img-thumbnail"
                             src="{{$user->shop_image ? str_replace('public', '/storage', $user->shop_image) : '' }}"
                             alt="your image"/>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('shop_name', 'Shop Name', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                <div class="col-lg-9 col-md-9 col-sm-12">
                    {!! Form::text('shop_name', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('warehouse_address', 'Warehouse Address', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                <div class="col-lg-9 col-md-9 col-sm-12">
                    {!! Form::text('warehouse_address', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">Warehouse Location</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <select class="form-control kt-select2" id="warehouse_location_select2_edit" name="warehouse_area"
                            style="width: 100%">
                        @foreach($cities as $city)
                            @if($city->areas->count())
                                <optgroup label="{{$city->name}}">
                                    @foreach($city->areas as $area)
                                        <option value="{{$area->id}}"
                                                @if(old('warehouse_location_id', $user->warehouse_location_id) == $area->id)
                                                selected
                                            @endif
                                        >{{$area->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('business_address', 'Business Address', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                <div class="col-lg-9 col-md-9 col-sm-12">
                    {!! Form::text('business_address', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">Business Location</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <select class="form-control kt-select2" id="business_location_select2_edit" name="business_area"
                            style="width: 100%">
                        @foreach($cities as $city)
                            @if($city->areas->count())
                                <optgroup label="{{$city->name}}">
                                    @foreach($city->areas as $area)
                                        <option value="{{$area->id}}"
                                                @if(old('business_location_id', $user->business_location_id) == $area->id)
                                                selected
                                            @endif
                                        >{{$area->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('return_address', 'Return Address', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                <div class="col-lg-9 col-md-9 col-sm-12">
                    {!! Form::text('return_address', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-lg-3 col-sm-12">Return Location</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <select class="form-control kt-select2" id="return_location_select2_edit" name="return_area"
                            style="width: 100%">
                        @foreach($cities as $city)
                            @if($city->areas->count())
                                <optgroup label="{{$city->name}}">
                                    @foreach($city->areas as $area)
                                        <option value="{{$area->id}}"
                                                @if(old('return_location_id', $user->return_location_id) == $area->id)
                                                selected
                                            @endif
                                        >{{$area->name}}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <hr>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection


@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#shop_image').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#shop_image_input").change(function () {
                readURL(this);
            });
        });
    </script>
@endpush
