<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    {{ Form::open(['route' => ['admin.location.countries.states.cities.areas.store', $country->id, $state->id, $city->id], 'method' => 'POST']) }}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => "col-form-label"]) !!}
                    {!! Form::text('name', null, ['class' => "form-control", "required" => "required"]) !!}
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
