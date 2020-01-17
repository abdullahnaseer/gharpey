<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    {{ Form::open(['method' => 'PUT', 'files' => true]) }}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => "col-form-label"]) !!}
                    {!! Form::text('name', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', 'Description', ['class' => "col-form-label"]) !!}
                    {!! Form::textarea('description', null, ['class' => "form-control", "required" => "required"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('price', 'Price', ['class' => "col-form-label"]) !!}
                    {!! Form::number('price', null, ['class' => "form-control", "required" => "required"]) !!}
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
