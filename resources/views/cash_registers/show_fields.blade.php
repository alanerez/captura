<div class="container mr-5 ml-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Name Field -->
            <div class="form-group">
                @php if(is_string($cashRegister->name)){
                $time = strtotime($cashRegister->name);
                $newDate = date('d M Y', $time);
                }else{
                $newDate = $cashRegister->name ;
                }
                @endphp
                {!! Form::label('name', 'Date:') !!}
                <p>{!! $newDate !!}</p>
            </div>

            <!-- Cash Field -->
            <div class="form-group">
                {!! Form::label('cash', 'Cash:') !!}
                <p>$ {!! number_format($cashRegister->cash, 2) !!}</p>
            </div>

            <!-- Transactions Field -->
            <div class="form-group">
                {!! Form::label('transactions', 'Transactions:') !!}
                <p>{!! $cashRegister->transactions !!}</p>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Created At Field -->
            <div class="form-group">
                {!! Form::label('created_at', 'Created At:') !!}
                <p>{!! $cashRegister->created_at !!}</p>
            </div>

            <!-- Updated At Field -->
            <div class="form-group">
                {!! Form::label('updated_at', 'Updated At:') !!}
                <p>{!! $cashRegister->updated_at !!}</p>
            </div>
            <div class="form-group">
                <button id="graph-btn" onclick="showGraph()" type="button" class="btn btn-primary">Show Graph</button>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <canvas id="graph" class="d-none"></canvas>
</div>
<div class="col-md-12">
    <table class="table table-responsive table-striped">
        <thead>
        <th>Month</th>
        <th>Gross Income</th>
        <th>Legal</th>
        <th>Admin</th>
        <th>Notary</th>
        <th>Sales Commission</th>
        <th>Management Commission</th>
{{--        <th>Bank Fees</th>--}}
        <th>Monthly Income</th>
        <th>Total</th>
        </thead>
        <tbody>
        @for($i = 1; $i <= 1; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td>$ {!! round($grossIncome, 2) !!}</td>
                <td>$ {!! round($legal, 2) !!}</td>
                <td>$ {!! round($admin, 2) !!}</td>
                <td>$ {!! round($notary, 2) !!}</td>
                <td>$ {!! round($salesComm, 2) !!}</td>
                <td>$ {!! round($managementComm, 2) !!}</td>
{{--                <td>$ {!! round($bankFees, 2) !!}</td>--}}
                <td>$ {!! $first = round($grossIncome - ($legal + $admin + $notary + $salesComm + $managementComm), 2) !!}</td>
                <td>$ {!! $fifth = $first!!}</td>
            </tr>
        @endfor
        @for($i = 2; $i <= 5; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td>$ {!! round($grossIncome, 2) !!}</td>
                <td>$ {!! round($legal, 2) !!}</td>
                <td>$ {!! round($admin, 2) !!}</td>
                <td>$ 0</td>
                <td>$ 0</td>
                <td>$ 0</td>
{{--                <td>$ {!! round($bankFees, 2) !!}</td>--}}
                <td>$ {!! round(($grossIncome - ($legal + $admin)), 2) !!}</td>
                <td>$ {!! $twentytwoth = $fifth += round(($grossIncome - ($legal + $admin)), 2) !!}</td>
            </tr>
            @php $loop2[] = $fifth; @endphp
        @endfor
        @for($i = 6; $i <= 22; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td>$ {!! round($grossIncome, 2) !!}</td>
                <td>$ 0</td>
                <td>$ {!! round($admin, 2) !!}</td>
                <td>$ 0</td>
                <td>$ 0</td>
                <td>$ 0</td>
{{--                <td>$ {!! round($bankFees, 2) !!}</td>--}}
                <td>$ {!! round($grossIncome - ($admin), 2) !!}</td>
                <td>$ {!! $twentytwoth += round($grossIncome - ($admin), 2) !!}</td>
            </tr>

            @php $loop3[] = $twentytwoth; @endphp
        @endfor
        </tbody>
    </table>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script>
    function showGraph(){
        if($('#graph-btn').html() == 'Show Graph'){
            $('#graph-btn').text('Hide Graph');
            $('#graph').removeClass('d-none');
        }else{
            $('#graph-btn').text('Show Graph');
            $('#graph').addClass('d-none');
        }
    }

    var data = {
        labels: ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th',
            '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21th', '22nd'],
        datasets: [
            {
                data: [{{$first}}, {{ $loop2[0]}}, {{ $loop2[1]}}, {{ $loop2[2]}}, {{ $loop2[3]}}, {{ $loop3[0] }},
                    {{ $loop3[1] }},  {{ $loop3[2] }}, {{ $loop3[3] }}, {{ $loop3[4] }}, {{ $loop3[5] }}, {{ $loop3[6] }},
                    {{ $loop3[7] }}, {{ $loop3[8] }}, {{ $loop3[9] }}, {{ $loop3[10] }}, {{ $loop3[11] }}, {{ $loop3[12] }},
                    {{ $loop3[13] }}, {{ $loop3[14] }}, {{ $loop3[15] }}, {{ $loop3[16] }}]
            }
        ]
    };

    window.onload = function() {
        var context = document.querySelector('#graph').getContext('2d');
        var myChart = new Chart(context, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: '22-month forecast'
                },
                legend: {
                    display: false,
                }
            }
        });
    }
</script>