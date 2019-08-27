@extends('layouts.lucid')
@section('breadcrumbs')
    {{ Breadcrumbs::render('available_numbers.index') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="container col-lg-12">
                        <h5>Purchase phone numbers</h5>
                        <h5>Available numbers</h5>
                        <p>For state area code: {{ $areaCode }}</p>
                        <p>The number you choose will be used to create a Lead Source. On the next page, you will set a name and forwarding number for this lead source.</p>
                        <table class="table">
                            <thead>
                            <th>Phone number</th>
                            <th>State</th>
                            <th></th>
                            </thead>
                            <tbody>
                            @foreach ($numbers as $number)
                                <tr>
                                    <td> {{ $number->friendlyName }} </td>
                                    <td> {{ $number->region }} </td>
                                    <td>
                                        {!! Form::open(['url' => route('lead_sources.store')]) !!}
                                        {!! Form::hidden('phoneNumber', $number->phoneNumber) !!}
                                        {!! Form::submit('Purchase', ['class' => 'btn btn-primary btn-xs']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop