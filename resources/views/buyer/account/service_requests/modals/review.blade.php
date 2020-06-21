<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    {{ Form::open(['method' => 'POST']) }}
    @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Review Service Seller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('review', 'Review', ['class' => "col-form-label"]) !!}
                    {!! Form::textarea('review', null, ['class' => "form-control", 'rows' => 2]) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('rating', 'Rating', ['class' => "col-form-label"]) !!}
                    {!! Form::select('rating', [
                        5 => '5 Stars',
                        4 => '4 Stars',
                        3 => '3 Stars',
                        2 => '2 Stars',
                        1 => '1 Stars',
                    ], null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
