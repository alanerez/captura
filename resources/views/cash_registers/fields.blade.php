

<!-- Submit Field -->
<div class="col-sm-12 pr-5 pl-5">
    <div class="row">
        <div class="form-group">
            {!! Form::label('Date:') !!}
            {!! Form::date('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('Amount:') !!}
            {!! Form::number('cash', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('Number of transactions:') !!}
            {!! Form::number('transactions', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row mt-2">
        <div class="form-group">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('cash-register.index') !!}" class="btn btn-default">Cancel</a>
        </div>
    </div>
</div>
