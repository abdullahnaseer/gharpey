<div class="kt-portlet kt-portlet--sortable questions-sortable choice-portlet">
    <div class="kt-portlet__head questions-head choice-head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Choice Option
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-group">
                <button onclick="return false;" role="button" class="btn btn-sm btn-icon btn-outline-success btn-elevate btn-icon-md up-question-btn"><i class="la la-arrow-up"></i></button>
                <button onclick="return false;" role="button" class="btn btn-sm btn-icon btn-outline-success btn-elevate btn-icon-md down-question-btn"><i class="la la-arrow-down"></i></button>
                <button onclick="return false;" role="button" class="btn btn-sm btn-icon btn-outline-danger btn-elevate btn-icon-md remove-question-btn"><i class="la la-close"></i></button>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="row">
            <div class="form-group col-sm-6 row">
                {!! Form::label('choice_text', 'Choice Text', ['class' => "col-form-label col-md-3"]) !!}
                <div class="col-md-9">
                    <input type="text" name="choice_text['.($question_index ?? '').']['.($choice_index ?? '').']" class="form-control choice_text" required value="{{$choice_text ?? ''}}" />
                </div>
            </div>
            <div class="form-group col-sm-6 row">
                {!! Form::label('choice_price_effect', 'Price Effect', ['class' => "col-form-label col-md-3"]) !!}
                <div class="col-md-9">
                    <input type="number" name="choice_price_effect['.($question_index ?? '').']['.($choice_index ?? '').']" class="form-control choice_price_effect" required value="{{$choice_price_effect ?? 0}}" />
                    <small class="form-text text-muted">
                        Use '0' for no price effect. Use negative number for price reduction.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
