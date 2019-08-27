@extends('layouts.lucid')
@section('breadcrumbs')
    {{ Breadcrumbs::render('leads.index') }}
@endsection
@section('content')
        @php 
            $inbound = 0;
            $outbound = 0;
        @endphp
        @foreach($call_summary as $call)
            @php
                $inbound += $call->inbound;
                $outbound += $call->outbound_dial;
            @endphp
        @endforeach
    <div class="container-fluid">
        <div class="row clearfix">
                <div class="col-lg-4 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                            <div class="p-1">
                                <h5> {{ $total_calls }} </h5>
                                <span>Total Calls</span>
                            </div>
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                            <div class="progress-bar" role="progressbar" aria-valuenow=""
                                aria-valuemin="0" aria-valuemax="100" style="width: " data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                            <div class="p-1">
                                <h5>{{ $inbound }}</h5>
                                <span>Inbound Calls</span>
                            </div>
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-purple m-b-0">
                            <div class="progress-bar" role="progressbar" aria-valuenow=""
                                aria-valuemin="0" aria-valuemax="100" style="width: " data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card overflowhidden">
                        <div class="body">
                            <div class="p-1">
                                <h5>{{ $outbound }}</h5>
                                <span>Outbound Calls</span>
                            </div>
                        </div>
                        <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                            <div class="progress-bar" role="progressbar" aria-valuenow=""
                                aria-valuemin="0" aria-valuemax="100" style="width: " data-transitiongoal="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h3>Call Tracking</h3>
                    </div>
                    <div class="container">
                    <!-- Nav pills -->
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#numbers">Available Numbers</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#logs">Log</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#chart">Chart</a>
                            </li>
                        </ul>
                        <hr>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="numbers" class="container tab-pane active"><br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>Add a new number</h5>
                                            <hr>
                                            <p>Create a new lead source by purchasing a new phone number. State Area code is optional</p>
                                            {!! Form::open(['url' => route('available_numbers.index'), 'method' => 'GET']) !!}
                                            {!! Form::label('areaCode', 'State Area code: ') !!}
                                            {!! Form::number('areaCode') !!}
                                            {!! Form::submit('Search', ['class' => 'btn btn-primary btn-xs']) !!}
                                            {!! Form::close() !!}
                                            <hr>
                                    </div>
                                    <div class="col-lg-6">
                                        @include('lead_sources.index', ['leadSources' => $leadSources, 'appSid' => $appSid, 'numbers' => $numbers, 'total_calls' => $total_calls])
                                    </div>
                                </div>
                            </div>
                            <div id="logs" class="container tab-pane fade"><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Call Leads</h5>
                                        <hr>
                                        <table class="table" id="source-datatable">
                                            <thead>
                                            <th>Lead source</th>
                                            <th>Calls</th>
                                            <th>%</th>
                                            </thead>
                                            <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($numbers as $index => $number)
                                            @php
                                                $percentage = $number->total_calls == 0 ? 0: ($number->total_calls / $total_calls) * 100;
                                            @endphp
                                                <tr>
                                                    <td><a href="/call-tracking/{{$number->sid}}"> {{ $number->phone_number }} </a></td>
                                                    <td> {{ $number->total_calls }} </td>
                                                    <td> {{ round($percentage, 2) }} %</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        @include('lead_sources.table', ['call_records' => $call_records])
                                    </div>
                                </div>
                            </div>
                            <div id="chart" class="container tab-pane fade"><br>
                                <h5>Charts</h5>
                                <p>The latest statistics about how the lead sources are performing</p>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Inbound vs Outgoing Calls</h5>
                                        <hr>
                                        <canvas id="pie-by-lead-source"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Inbound calls (%)</h5>
                                        <hr>
                                        <canvas id="pie-by-city"></canvas>
                                    </div>
                                    <hr>
                                </div>
                                <hr>
                                <h5>Calls by Source</h5>
                                <hr>
                                <canvas id="calls-by-source"></canvas>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js') !!}
    {!! Html::script('//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js')!!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    $('#lead-datatable').DataTable( {
        responsive: true
    } );
    $('#source-datatable').DataTable( {
        responsive: true
    } );

        var inboundConfig = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        @php 
                            $inbound = 0;
                            $outbound = 0;
                        @endphp
                        @foreach($call_summary as $call)
                            @php
                                $inbound += $call->inbound;
                                $outbound += $call->outbound_dial;
                            @endphp
                        @endforeach
                        {{ $inbound }},
                        {{ $outbound }}
                    ],
                    backgroundColor: [
                        'hsl(' + (180 * {{ $inbound }} / {{ count($call_summary) }} ) + ', 100%, 50%)',
                        'hsl(' + (180 * {{ $outbound }} / {{ count($call_summary) }} ) + ', 100%, 50%)',
                    ],
                    // label: 'Dataset 1'
                }],
                labels: [
                    'Incoming',
                    'Outgoing'
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Call Inbound Analysis'
                },
                legend: {
                    display: true,
                    position: 'right'
                }
            }
        };

        var outboundConfig = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        @foreach($call_summary as $call)
                            {!! round(($call->inbound / $total_calls) * 100,2) !!},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($call_summary as $call)
                        'hsl(' + (180 * {{ $call->inbound }} / {{ count($call_summary) }} ) + ', 100%, 50%)',
                        @endforeach
                    ],
                    // label: 'Dataset 1'
                }],
                labels: [
                        @foreach($call_summary as $call)
                            '{!! $call->formatted_phone_number !!}',
                        @endforeach
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Call Inbound Analysis'
                },
                legend: {
                    display: false,
                    position: 'right'
                }
            }
        };

        var callData = {
            labels: [
            ],
            datasets: [
                @foreach($call_summary as $summary)
                {
                    label: '{{ $summary->formatted_phone_number }}',
                    backgroundColor: 'hsl(' + (180 * {{ $summary->inbound }} / {{ count($call_summary) }} ) + ', 100%, 50%)',
                    borderColor: 'rgba(0, 255, 0, 0.2)',
                    data: [
                        @php
                            $total = $summary->inbound + $summary->outbound_dial;
                        @endphp
                        {{ $total }},
                    ],
                    fill: true,
                },
                @endforeach
            ]
        };

        window.onload = function() {
            var context = document.querySelector('#calls-by-source').getContext('2d');
            var myChart = new Chart(context, {
                type: 'bar',
                data: callData,
                options: {
                    responsive: true,
                    title: {
                        display: false,
                        text: 'Calls by Source'
                    },
                    legend: {
                        display: false,
                    }
                }
            });

            var contextAnalysis = document.querySelector("#pie-by-lead-source").getContext('2d');
            var myChart = new Chart(contextAnalysis, inboundConfig);

            var contextAnalysis = document.querySelector("#pie-by-city").getContext('2d');
            var myChart = new Chart(contextAnalysis, outboundConfig);
        }
    </script>
@stop