<div class="modal fade" id="goal_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_label">Add Monthly Goal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'add.goals']) !!}
                <div class="col-sm-12 pr-5 pl-5">
                    <div class="row">
                        <div class="form-group">
                            {!! Form::hidden('type', 'monthly') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('Amount:') !!}
                            {!! Form::text('value', null, ['class' => 'form-control', 'id' => 'goal-amount', 'required']) !!}
                        </div>
                    </div>
                    <div class="row float-right">
                        <a href="{!! route('cash-register.dashboard') !!}" class="btn btn-default m-1">Cancel</a>
                        {!! Form::submit('Save', ['class' => 'btn btn-primary m-1', 'id' => 'save-goal']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
