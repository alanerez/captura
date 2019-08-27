@extends('layouts.lucid')
@section('breadcrumbs')
    {{ Breadcrumbs::render('leads.index') }}
@endsection
@section('content')
@php
    $inbound = 0;
    $outbound = 0;
    foreach($calls as $call){
        if($call->direction == 'inbound'){
            $inbound += 1;
        }elseif($call->direction == 'outbound-dial'){
            $outbound += 1;
        }
    }
@endphp
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-6">
            <div class="card overflowhidden">
                <div class="body">
                    <div class="p-1">
                        <h5> {{ count($calls) }} </h5>
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
        <div class="card overflowhidden">
            <div class="header">
                <h5>Lead - {{ $check->formatted_phone_number }}</h5>
                <hr>
            </div>
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-12 table-responsive">
                        <table class="table" id="source-datatable">
                            <thead>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Caller Name</th>
                            <th>Direction</th>
                            <th>Duration</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            </thead>
                            <tbody>
                            @foreach ($calls as $index => $call)
                            @php 
                                $dateCreated = $call->dateCreated->format('d M Y H:i:s');
                                $startTime = $call->startTime->format('d M Y H:i:s');
                                $endTime = $call->endTime->format('d M Y H:i:s');
                            @endphp
                                <tr>
                                    <td>{{ $dateCreated }} </td>
                                    <td>{{ $call->fromFormatted }} </td>
                                    <td> {{ $call->toFormatted }} </td>
                                    <td> {{ $call->callerName }} </td>
                                    <td> {{ $call->direction }} </td>
                                    <td> {{ $call->duration }} s</td>
                                    <td> {{ $startTime }} </td>
                                    <td> {{ $endTime }} </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('#source-datatable').DataTable( {
            responsive: true
        } );
    </script>
@endsection