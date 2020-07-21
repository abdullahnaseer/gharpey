<!-- Modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['files' => true, 'class' => 'kt-form kt-form--fit kt-form--label-right']) }}
            <div class="modal-body">

                <div class="form-group">
                    {!! Form::label('name', 'Name', ['class' => "col-form-label"]) !!}
                    {!! Form::text('name', null, ['class' => "form-control", "required" => "required", "disabled"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('price', 'Total Price', ['class' => "col-form-label"]) !!}
                    {!! Form::text('price', null, ['class' => "form-control", "required" => "required", "disabled"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('status', 'Status', ['class' => "col-form-label"]) !!}
                    {!! Form::text('status', null, ['class' => "form-control", "required" => "required", "disabled"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('quantity', 'Quantity', ['class' => "col-form-label"]) !!}
                    {!! Form::text('quantity', null, ['class' => "form-control", "required" => "required", "disabled"]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('featured_image', 'Featured Image', ['class' => "col-form-label"]) !!}
                    <div class="form-group row" style="margin: auto" id="featured_image"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
