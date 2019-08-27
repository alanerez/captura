<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Lead Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="save-form" method="POST" action="{{ route('lead-status.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="value[name]" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <label>Color</label>
                            <div class="input-group colorpicker">
                                <input type="text" class="form-control" name="value[color]" value="#00AABB" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><span class="input-group-addon"><i></i></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="save-form" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>
