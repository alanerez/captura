<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Ticket Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="update-form" method="POST" action="">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="value[name]" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <label for="color">Color</label>
                            <div class="input-group colorpicker">
                                <input type="text" class="form-control" id="color" name="value[color]" placeholder="Color" value="#00AABB" required>
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
                <button type="submit" form="update-form" class="btn btn-sm btn-secondary">Update</button>
            </div>
        </div>
    </div>
</div>
