<div class="modal fade" id="lead-fields-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideright modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lead Column</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <small>Drag & drop to order and select which columns are displayed in the entries table.</small>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="header">
                                <h2>Active Columns</h2>
                            </div>
                            <div class="body">
                                <form id="save-lead-field-settings" action="{{ route('lead-field-settings.update') }}" method="POST">
                                    @csrf
                                    <div class="clearfix">
                                        <ul class="dd sortable" style="padding: 20px;">
                                            @foreach($fields as $field)
                                            <li class="dd-handle">{{ $field }}
                                                <input type="hidden" name="value[]" value="{{ $field }}">
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="header">
                                <h2>Inactive Columns</h2>
                            </div>
                            <div class="body">
                                <div class="clearfix">
                                    <ul class="dd sortable" style="padding: 20px;">
                                        @foreach($in_active_fields as $field)
                                        <li class="dd-handle">{{ $field }}
                                            <input type="hidden" name="value[]" value="{{ $field }}">
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                <button type="submit" form="save-lead-field-settings" class="btn btn-sm btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>
