<div class="modal fade add-department-modal" id="add-department-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Department</h5>
                <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="save-department-form">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Incoming Server</label>
                                <input type="text" class="form-control incoming_host" name="incoming_host" placeholder="Host" required>
                            </div>
                            <div class="form-group">
                                <p class="mb-0">Incoming Protocol</p>
                                <label class="fancy-radio"><input name="incoming_protocol" class="incoming_protocol" value="imap" type="radio" checked><span><i></i>IMAP</span></label>
                                <label class="fancy-radio"><input name="incoming_protocol" class="incoming_protocol" value="pop3" type="radio"><span><i></i>POP3</span></label>
                            </div>
                            <div class="form-group">
                                <p class="mb-0">Incoming Encryption</p>
                                <label class="fancy-radio"><input name="incoming_encryption" class="incoming_encryption" value="tls" type="radio" checked><span><i></i>TLS</span></label>
                                <label class="fancy-radio"><input name="incoming_encryption" class="incoming_encryption" value="ssl" type="radio"><span><i></i>SSL</span></label>
                                <label class="fancy-radio"><input name="incoming_encryption" class="incoming_encryption" value="false" type="radio"><span><i></i>No Encryption</span></label>
                            </div>
                            <div class="form-group">
                                <label>Outgoing Server</label>
                                <input type="text" class="form-control outgoing_host" name="outgoing_host" placeholder="Host" required>
                            </div>
                            <div class="form-group">
                                <p class="mb-0">Outgoing Encryption</p>
                                <label class="fancy-radio"><input name="outgoing_encryption" class="outgoing_encryption" value="tls" type="radio" checked><span><i></i>TLS</span></label>
                                <label class="fancy-radio"><input name="outgoing_encryption" class="outgoing_encryption" value="ssl" type="radio"><span><i></i>SSL</span></label>
                                <label class="fancy-radio"><input name="outgoing_encryption" class="outgoing_encryption" value="false" type="radio"><span><i></i>No Encryption</span></label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Department Name</label>
                                <input type="text" class="form-control name" name="name" placeholder="Department Name" required>
                            </div>
                            <div class="form-group">
                                <label>Department Email</label>
                                <input type="email" class="form-control email" name="email" placeholder="Department Email" required>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control username" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-light close-modal" data-dismiss="modal">Close</button>
                <button type="submit" id="save-department-form-btn" class="btn btn-sm btn-secondary  close-modal">Save</button>
            </div>
        </div>
    </div>
</div>
