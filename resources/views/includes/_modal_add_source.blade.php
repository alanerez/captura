<div class="modal fade add-source-modal" id="add-source-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Lead Source</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="save-source-form">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control source_name" name="value[name]" placeholder="Name" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light close-modal" data-dismiss="modal">Close</button>
                <button type="submit" id="save-source-form-btn" class="btn btn-sm btn-secondary close-modal">Save</button>
            </div>
        </div>
    </div>
</div>
