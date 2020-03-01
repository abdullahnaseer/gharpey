<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Moderator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'admin.users.moderators.store', 'method' => 'POST', 'class' => 't-form kt-form--fit kt-form--label-right']) }}
            <div class="modal-body">
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
                    {!! Form::label('address', 'Address', ['class' => "col-form-label col-lg-3 col-sm-12"]) !!}
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {!! Form::text('address', null, ['class' => "form-control", "required" => "required"]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-3 col-sm-12">Location</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <select class="form-control kt-select2" id="location_select2_create" name="location_id"
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
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
