<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    {{ Form::open(['method' => 'PUT', 'files' => true]) }}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
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
                    {!! Form::label('inventory', 'Inventory', ['class' => "col-form-label"]) !!}
                    {!! Form::number('inventory', null, ['class' => "form-control", "required" => "required", "min" => 0]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('category_id', 'Category', ['class' => "col-form-label"]) !!}

                    <select name="category_id" id="category_id" class="form-control" required="required">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if(old('category_id') == $category->id)  selected @endif >
                                {{$category->name}}
                            </option>

                            @foreach($category->child_categories as $child_category)
                                <option value="{{$child_category->id}}" @if(old('category_id') == $child_category->id)  selected @endif >
                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $child_category->name}}
                                </option>

                                @foreach($child_category->child_categories as $child_category1)
                                    <option value="{{$child_category1->id}}" @if(old('category_id') == $child_category1->id)  selected @endif >
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $child_category1->name}}
                                    </option>
                                @endforeach

                            @endforeach

                        @endforeach
                    </select>

{{--                    {!! Form::select('category_id', $categories->pluck('name', 'id'), null, ['class' => "form-control", "required" => "required"]) !!}--}}
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
