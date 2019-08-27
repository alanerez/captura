<h5>Call Logs</h5>
<hr>
<div class="row">
    <div class="col-lg-12">
        <table class="table" id="lead-datatable">
            <thead>
            <th></th>
            <th>Date</th>
            <th>Number</th>
            <th>Status</th>
            <th>Duration</th>
            </thead>
            <tbody>
            @foreach ($call_records as $index=>$record)
                <tr>
                    @php 
                        $toDate = strtotime($record->startTime);
                        $date = date('d M Y', $toDate);
                    @endphp
                    <td> {{ ++$index }} </td>
                    <td> {{ $date }} </td>
                    <td> {{ $record->fromFormatted }} </td>
                    <td> {{ $record->status }} </td>
                    <td> {{ $record->duration }} s</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>