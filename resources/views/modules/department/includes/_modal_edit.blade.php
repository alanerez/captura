<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideright" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-slideright" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-1">
                <form id="update-form" method="POST" action="">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="incoming_host">Incoming Server</label>
                                <input type="text" class="form-control" name="incoming_host" id="incoming_host" placeholder="Host" required>
                            </div>
                            <div class="form-group">
                                <p class="mb-0">Incoming Protocol</p>
                                <label class="fancy-radio"><input name="incoming_protocol" id="incoming_imap" value="imap" type="radio" checked><span><i></i>IMAP</span></label>
                                <label class="fancy-radio"><input name="incoming_protocol" id="incoming_pop3" value="pop3" type="radio"><span><i></i>POP3</span></label>
                            </div>
                            <div class="form-group">
                                <p class="mb-0">Incoming Encryption</p>
                                <label class="fancy-radio"><input name="incoming_encryption" id="incoming_tls" value="tls" type="radio" checked><span><i></i>TLS</span></label>
                                <label class="fancy-radio"><input name="incoming_encryption" id="incoming_ssl" value="ssl" type="radio"><span><i></i>SSL</span></label>
                                <label class="fancy-radio"><input name="incoming_encryption" id="incoming_no_encryption" value="false" type="radio"><span><i></i>No Encryption</span></label>
                            </div>
                            <div class="form-group">
                                <label for="outgoing_host">Outgoing Server</label>
                                <input type="text" class="form-control" name="outgoing_host" id="outgoing_host" placeholder="Host" required>
                            </div>
                            <div class="form-group">
                                <p class="mb-0">Outgoing Encryption</p>
                                <label class="fancy-radio"><input name="outgoing_encryption" id="outgoing_tls" value="tls" type="radio" checked><span><i></i>TLS</span></label>
                                <label class="fancy-radio"><input name="outgoing_encryption" id="outgoing_ssl" value="ssl" type="radio"><span><i></i>SSL</span></label>
                                <label class="fancy-radio"><input name="outgoing_encryption" id="outgoing_no_encryption" value="false" type="radio"><span><i></i>No Encryption</span></label>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="name">Department Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Department Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Department Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Department Email" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
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
