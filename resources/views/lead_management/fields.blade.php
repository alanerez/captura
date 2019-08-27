

<!-- Submit Field -->
<div class="col-sm-12 pr-5 pl-5">
    <div class="row">
        <div class="form-group">
            {!! Form::label('customerid', 'Customer ID:') !!}
            {!! Form::text('customerid', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('firstname', 'First Name:') !!}
            {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('lastname', 'Last Name:') !!}
            {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('address', 'Address:') !!}
            {!! Form::text('address', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('city', 'City:') !!}
            {!! Form::text('city', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('state', 'State:') !!}
            {!! Form::text('state', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('zip', 'Zip:') !!}
            {!! Form::text('zip', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('altphone', 'Primary Phone:') !!}
            {!! Form::text('altphone', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('email', 'Email:') !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group">
            {!! Form::label('lead_source', 'Lead Source:') !!}
            {!! Form::select('lead_source', ['' => 'SELECT ONE', ], '', ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row mt-2">
        <div class="form-group">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('cash-register.index') !!}" class="btn btn-default">Cancel</a>
        </div>
    </div>
</div>
