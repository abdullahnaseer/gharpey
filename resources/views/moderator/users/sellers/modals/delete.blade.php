<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete Seller?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure? This action is irreversible will delete this Seller permanently.</p>
            </div>
            <div class="modal-footer">
                {{ Form::open(['method' => 'DELETE']) }}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-danger" value="Delete">
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
