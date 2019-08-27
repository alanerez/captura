<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="save-form" method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <label>Permissions</label>
                        </div>
                        @foreach($permissions->chunk(3) as $chunk_permissions)
                        <div class="col-xl-4">
                            @foreach($chunk_permissions as $key => $value)
                            <div class="custom-control custom-checkbox custom-control-primary mb-2">
                                <input type="checkbox" class="custom-control-input" id="add-perm-{{ $value->id }}" name="permissions[]" value="{{ $value->id }}">
                                <label class="custom-control-label" for="add-perm-{{ $value->id }}">{{ $value->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
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
