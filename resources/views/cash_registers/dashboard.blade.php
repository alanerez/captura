@extends('layouts.lucid')

@section('styles')
    <link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/morrisjs/morris.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/fullcalendar/fullcalendar.min.css') }}">
    <style type="text/css">
        .fc-unthemed .fc-list-item:hover td {
            background-color: unset;
            opacity: 0.8;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid p-3 mt-4">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <div class="p-1">
                            <h5>$ {{ number_format($monthlyGross['totalDebt'], 2) }} <i class="fa fa-shopping-cart float-right"></i></h5>
                            <span id="t-debt">Total Debt</span>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $m_pro_total >= 100 ? 100 : number_format($m_pro_total, 2) }}"
                             aria-valuemin="0" aria-valuemax="100" style="width: {{ $m_pro_total >= 100 ? 100 : number_format($m_pro_total, 2) }}%" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <div class="p-1">
                            <h5>{{ $monthlyGross['transactions'] }} <i class="fa fa-handshake-o float-right"></i></h5>
                            <span id='t-transactions'>Total Transactions</span>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-purple m-b-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ number_format($m_transactions, 2) }}"
                             aria-valuemin="0" aria-valuemax="100" style="width: {{ number_format($m_transactions, 2) }}%" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <div class="p-1">
                            <h5>$ {{ number_format($monthlyGross['income'], 2) }} <i class="fa fa-dollar float-right"></i></h5>
                            <span id='month-gross'>Monthly Gross</span>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ number_format($m_gross_goal, 2) }}"
                             aria-valuemin="0" aria-valuemax="100" style="width: {{ number_format($m_gross_goal, 2) }}%" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card overflowhidden">
                    <div class="body">
                        <div class="p-1">
                            <h5 id="ytd">{{ number_format(\App\Http\Controllers\CashRegisterController::ytdGrowth()['ytd'], 2) }}% <i class="fa fa-heart-o float-right"></i></h5>
                            <span id="ytd-label">Growth (YTD)</span>
                        </div>
                    </div>
                    <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                        <div class="progress-bar ytd" role="progressbar" aria-valuenow="{{ number_format(\App\Http\Controllers\CashRegisterController::ytdGrowth()['growth'], 2) }}"
                             aria-valuemin="0" aria-valuemax="100" style="width: {{ number_format(\App\Http\Controllers\CashRegisterController::ytdGrowth()['growth'], 2) }}%" data-transitiongoal="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="card p-3">
                    <div class="header">
                        <div class="row col-md-12">
                            <div class="col-md-4">
                                <h2 id="a-report" class="float-left">Yearly Perspective</h2>
                            </div>
                            <div class="form-group col-md-8 text-right">
                                <select id="selectMonth" class="" style="border-radius: 5px">
                                    <option selected value="annual" id="month">Annual</option>
                                    <option value="1" class="month">January</option>
                                    <option value="2" class="month">February</option>
                                    <option value="3" class="month">March</option>
                                    <option value="4" class="month">April</option>
                                    <option value="5" class="month">May</option>
                                    <option value="6" class="month">June</option>
                                    <option value="7" class="month">July</option>
                                    <option value="8" class="month">August</option>
                                    <option value="9" class="month">September</option>
                                    <option value="10" class="month">October</option>
                                    <option value="11" class="month">November</option>
                                    <option value="12" class="month">December</option>
                                </select>
                                <select id="selectYear" class="" style="border-radius: 5px">
                                    <option selected value="2019" id="year">2019</option>
                                    <option value="2020" class="year">2020</option>
                                    <option value="2021" class="year">2021</option>
                                </select>
                                {{--                                <select id="selectProjection" style="border-radius: 5px">--}}
{{--                                    <option selected class="projection">Select One</option>--}}
{{--                                    <option value="monthOnly" class="projection">Month Only</option>--}}
{{--                                    <option value="yearOnly" class="projection">Year Only</option>--}}
{{--                                    <option value="monthAndYear" class="projection">Month and Year</option>--}}
{{--                                </select>--}}
                                <button class="btn btn-primary btn-sm" id="search-m">search</button>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row mb-5">
                            <div class="col-md-3 text-center">
                                <h6 id="t-profit">Fees to Date</h6>
                                <h6 class="text-warning font-weight-bold" id="a-fees-value">${{ number_format($totalProfit['payables'], 2) }}</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <h6 id="a-revenue">Monthly Revenue</h6>
                                <h6 class="text-primary font-weight-bold" id="a-revenue-value">${{ number_format($totalProfit['income'], 2) }}</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <h6 id="a-fees">Total Sales</h6>
                                <h6 class="text-success font-weight-bold" id="t-profit-value">${{ number_format($totalProfit['profit'], 2) }}</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <h6 id="a-fees">Attrition</h6>
                                <h6 class="text-danger font-weight-bold" id="t-attrition-value">${{ number_format($totalProfit['profit'] * .10, 2) }}</h6>
                            </div>
                        </div>
                        <canvas id="graph"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="card pb-3 pr-3 pl-3">
                    <div class="row">
                        <div class="header">
                            <h2>Income Analysis</h2>
                            @php
                                $m = date('m');
                                $current = \App\Http\Controllers\CashRegisterController::monthlyGross($m)['income'];
                                $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($m - 1)['income'];
                                $previous == 0 ? $mGrowth = 100 : $mGrowth = ($current - $previous) / $previous;
                            @endphp
                            <span style="font-size: 10px;">{!! round($mGrowth, 2) !!}% High than last month</span>
                        </div>
                        <canvas id="analysis-graph"></canvas>
                    </div>
                </div>
                <div class="card pb-3 pr-3 pl-3">
                    <div class="row">
                        <div class="header">
                            <h2>Monthly Gross Income</h2>
                            <span style="font-size: 10px;">Overall: <strong>{{ number_format(\App\Http\Controllers\CashRegisterController::monthlyGross($m)['income'], 2) }}</strong></span>
                        </div>
                        <canvas id="income-graph"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript">
        // $('#selectProjection').on('change', function () {
        //     var id = $(this).val();
        //     if(id == 'monthOnly'){
        //         $('#selectMonth').removeClass('d-none');
        //         $('#selectYear').addClass('d-none');
        //         $('#search-m').on('click', function () {
        //             var sMonth = $('#selectMonth').val();
        //             location.href = '/sales-projection/month/'+ sMonth + "/2019";
        //         })
        //     }
        //     else if(id == 'yearOnly'){
        //         $('#selectMonth').addClass('d-none');
        //         $('#selectYear').removeClass('d-none');
        //         $('#search-m').on('click', function () {
        //             var sYear = $('#selectYear').val();
        //             location.href = '/sales-projection/month/annual' + "/" + sYear;
        //         })
        //     }else{
        //         $('#selectMonth').removeClass('d-none');
        //         $('#selectYear').removeClass('d-none');
        //         $('#search-m').on('click', function () {
        //             var sMonth = $('#selectMonth').val();
        //             var sYear = $('#selectYear').val();
        //             location.href = '/sales-projection/month/' + sMonth + "/" + sYear;
        //         })
        //     }
        // })

        $('#search-m').on('click', function () {
            var sMonth = $('#selectMonth').val();
            var sYear = $('#selectYear').val();
            location.href = '/sales-projection/month/' + sMonth + "/" + sYear;
        })

        var d = new Date();
        var m = d.getMonth();
        var y = d.getFullYear();
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',y];
        var month = [];
        for(var i = m; i < 12; i++){
            month.push(months[i]);
        }

        @php
            /* $currentYear = $totalProfit['totalDebt'];
            $prevYear = $totalProfit['totalDebt'];
            if($prevYear == 0){
                $ytd = 0;
            }else{
                $ytd = ($currentYear / $prevYear) * 100;
            } */

        $month = date('m');

        if($month == 1){
                $currentMonth = \App\Http\Controllers\CashRegisterController::monthlyGross($month)['income'];
                $prevMonth = \App\Http\Controllers\CashRegisterController::monthlyGross(12)['income'];
                if($prevMonth == 0){
                    $ytd = 100;
                }else{
                    $ytd = ($currentMonth - $prevMonth) / $prevMonth;
                }
            }else{
                $currentMonth = \App\Http\Controllers\CashRegisterController::monthlyGross($month)['income'];
                $prevMonth = \App\Http\Controllers\CashRegisterController::monthlyGross($month -1)['income'];
                if($prevMonth == 0){
                    $ytd = 0;
                }else{
                    $ytd = ($currentMonth - $prevMonth) / $prevMonth;
                }
            }
        @endphp
        @php $d = date('m'); 
            $attrition_fees = ($monthlyGross['legal'] + $monthlyGross['admin'] + $monthlyGross['notary']) * .10;
            $attrition_commission = ($monthlyGross['salesComm'] + $monthlyGross['managementComm']) * .10;
            $monthly_sales = $monthlyGross['income'];
            $sales = $monthlyGross['income'] - ($monthlyGross['income'] * .10);
            $fees = $monthlyGross['monthlyPayables'] -  $attrition_commission;
            $profit = $sales - $fees;
            $attrition = ($monthly_sales * .10) + $attrition_commission;
        @endphp
        $('#t-debt').text(months[{{$d}} - 1]+" Debt");
        $('#t-transactions').text(months[{{$d}} - 1]+" Transactions");
        $('#month-gross').text(months[{{$d}} - 1]+" Gross");
        $('#ytd-label').text(months[{{$d}} - 1]+" Growth");
        $('#t-profit-value').text('$' + '{{ number_format($profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format($attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($fees, 2) }}')
        $('#ytd').text('{{number_format($ytd, 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        var annualData = {
            labels: months,
            datasets: [{
                label: 'Total Sales',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @for($j = 1; $j < $month; $j++)
                    {{ $profit = 0 }},
                    @endfor
                    @for($k = $month; $k <= $month; $k++)
                    @php
                        $monthlyGross = \App\Http\Controllers\CashRegisterController::monthlyGross($month);
                        $first = - $monthlyGross['monthlyPayables'];
                        $fifth = 0;
                    @endphp
                    {!! $first !!},
                    @endfor
                    @for($k = $month+1; $k <=$month+4; $k++)
                    @php
                        $fifth += ($monthlyGross['totalInc']) - $monthlyGross['legal'] - $monthlyGross['admin'];
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @php
                        $ytotal = ($monthlyGross['totalInc'] * (13-$month)) - $monthlyGross['monthlyPayables'] - (($monthlyGross['legal'] + $monthlyGross['admin']) * (4));
                    @endphp
                    {!! $ytotal !!},
                ],
                fill: true,
            }, {
                label: 'Monthly Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @for($j = 1; $j < $month; $j++)
                    {{ $profit = 0 }},
                    @endfor
                    @for($k = $month; $k <= $month; $k++)
                    @php
                        $monthlyGross = \App\Http\Controllers\CashRegisterController::monthlyGross($month);
                        $first = 0;
                    @endphp
                    {!! $fifth = $first !!},
                    @endfor
                    @for($k = $month+1; $k <=12; $k++)
                    @php
                        $fifth += $monthlyGross['totalInc'];
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @php
                        $ytotal = ($monthlyGross['totalInc'] * (13-$month));
                    @endphp
                    {!! $ytotal !!},
                ],
            }, {
                label: 'Fees to Date',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($j = 1; $j < $month; $j++)
                    {{ $profit = 0 }},
                    @endfor
                    @for($k = $month; $k <= $month; $k++)
                    @php
                        $monthlyGross = \App\Http\Controllers\CashRegisterController::monthlyGross($month);
                        $first = $monthlyGross['monthlyPayables'];
                    @endphp
                    {!! $first !!},
                    @endfor
                    @for($k = $month+1; $k <=12; $k++)
                    @php
                        $fifth = ($monthlyGross['legal'] + $monthlyGross['admin']);
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @php
                        $ytotal = $monthlyGross['monthlyPayables'] + (($monthlyGross['legal'] + $monthlyGross['admin']) * 4);
                    @endphp
                    {!! $ytotal !!},
                ],
            }]
        };

        @php
            $current = \App\Http\Controllers\CashRegisterController::monthlyGross($id);
            $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($id - 1);
        @endphp
        var analysisConfig = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        @php
                            $prev = $previous['income'];
                            $now = $current['income'];
                        @endphp
                        {!! $prev !!},
                        {!! $now !!}
                    ],
                    backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                    // label: 'Dataset 1'
                }],
                labels: ['Previous Month', 'Current Month']
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Income Analysis'
                },
                legend: {
                    display: false,
                }
            }
        };

        var income = {
            labels: months,
            datasets: [{
                label: 'Monthly Income',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($i = 1; $i <= 12; $i++)
                    @php
                        $grossIncome = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                    @endphp
                    {!! $grossIncome['income'] !!},
                    @endfor
                ],
            }]
        };

        window.onload = function() {
            var context = document.querySelector('#graph').getContext('2d');
            var myChart = new Chart(context, {
                type: 'line',
                data: annualData,
                options: {
                    responsive: true,
                    title: {
                        display: false,
                        text: 'Annual Report'
                    },
                    legend: {
                        display: true,
                    }
                }
            });

            var contextAnalysis = document.querySelector('#analysis-graph').getContext('2d');
            var myChart = new Chart(contextAnalysis, analysisConfig);

            var contextIncome = document.querySelector('#income-graph').getContext('2d');
            var myChart = new Chart(contextIncome, {
                type: 'line',
                data: income,
                options: {
                    responsive: true,
                    title: {
                        display: false,
                        text: 'Income Analysis'
                    },
                    legend: {
                        display: false,
                    }
                }
            });
        }
    </script>
@endsection

