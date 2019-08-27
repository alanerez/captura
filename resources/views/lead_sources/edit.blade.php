@extends('layouts.lucid')
@section('breadcrumbs')
    {{ Breadcrumbs::render('leads.index') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h1>Edit a lead source</h1>
                        <hr>
                    </div>
                    <div class="container">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <h3>Number: {!! $leadSource->number !!}</h3>
                            </div>

                            {!! Form::model($leadSource, ['url' => route('lead_sources.update', $leadSource->id), 'method' => 'PUT']) !!}
                            <div class="form-group">
                                {!! Form::label('description', 'Lead source description:') !!}
                                {!! Form::text('description', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('forwarding_number', 'Lead forwarding number:') !!}
                                {!! Form::text('forwarding_number', '', ['class' => 'form-control']) !!}
                            </div>
                            <div class="row pl-3 pr-3 pb-4">
                                {!! Form::submit('Save', ['class' => 'btn btn-primary btn-sm m-1']) !!}
                                {!! Form::close() !!}

                                {!! Form::open(['url' => route('lead_sources.destroy', $leadSource->id),
                                                'method' => 'DELETE']) !!}
                                {!! Form::submit('Delete this number', ['class' => 'btn btn-danger btn-sm m-1']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop