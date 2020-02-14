<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    {{ Form::open(['route' => 'seller.services.store', 'method' => 'POST', 'files' => true]) }}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('service_id', 'Service', ['class' => "col-form-label"]) !!}
                    {!! Form::select('service_id', $services->pluck('name', 'id'), null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('price', 'Price', ['class' => "col-form-label"]) !!}
                    {!! Form::number('price', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description', ['class' => "col-form-label"]) !!}
                    {!! Form::textarea('description', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('featured_image', 'Featured Image', ['class' => "col-form-label"]) !!}
                    {!! Form::file('featured_image') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('cities', 'Cities Available', ['class' => "col-form-label"]) !!}
                    {!! Form::select('cities', $cities->pluck('name', 'id'), null, ['class' => "form-control", "multiple" => "multiple"]) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
