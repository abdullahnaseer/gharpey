<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Edit Seller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['method' => 'PUT', 'class' => 'kt-form kt-form--fit kt-form--label-right']) }}
            <div class="modal-body">
                <div class="form-group row">
                    {!! Form::label('shop_name', 'Shop Name', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {!! Form::text('shop_name', null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('name', 'Name', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {!! Form::text('name', null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('email', 'Email', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {!! Form::email('email', null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('phone', 'Phone', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {!! Form::text('phone', null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('cnic', 'CNIC', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {!! Form::text('cnic', null, ['class' => "form-control", "required" => "required"]) !!}
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
                        <select class="form-control kt-select2" id="warehouse_location_select2_edit"
                                name="warehouse_location_id"
                                style="width: 100%">
                            @foreach($cities as $city)
                                @if($city->areas->count())
                                    <optgroup label="{{$city->name}}">
                                        @foreach($city->areas as $area)
                                            <option value="{{$area->id}}">{{$area->name}}</option>
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
                        <select class="form-control kt-select2" id="business_location_select2_edit"
                                name="business_location_id"
                                style="width: 100%">
                            @foreach($cities as $city)
                                @if($city->areas->count())
                                    <optgroup label="{{$city->name}}">
                                        @foreach($city->areas as $area)
                                            <option value="{{$area->id}}">{{$area->name}}</option>
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
                        <select class="form-control kt-select2" id="return_location_select2_edit"
                                name="return_location_id"
                                style="width: 100%">
                            @foreach($cities as $city)
                                @if($city->areas->count())
                                    <optgroup label="{{$city->name}}">
                                        @foreach($city->areas as $area)
                                            <option value="{{$area->id}}">{{$area->name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
