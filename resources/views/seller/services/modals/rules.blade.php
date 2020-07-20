<!-- Modal -->
<div class="modal fade" id="rulesModal" tabindex="-1" role="dialog" aria-labelledby="rulesModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Rules</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group form-row">
                    {!! Form::label('min_rule', 'Minimum Length', ['class' => "col-form-label col-sm-3"]) !!}
                    {!! Form::number('min_rule', null, ['class' => "form-control col-sm-9", "required" => "required"]) !!}
                </div>
                <div class="form-group form-row">
                    {!! Form::label('max_rule', 'Maximum Length', ['class' => "col-form-label col-sm-3"]) !!}
                    {!! Form::number('max_rule', null, ['class' => "form-control col-sm-9", "required" => "required"]) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
