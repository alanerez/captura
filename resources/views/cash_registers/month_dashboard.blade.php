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
                            <span id="t-transactions">Total Transactions</span>
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
                            <span id="month-gross">Monthly Gross</span>
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
                            <div class="form-group col-md-8 text-right p-0">
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
                                <h6 id="a-fees">Annual Fees</h6>
                                <h6 class="text-warning font-weight-bold" id="a-fees-value">${{ number_format(\App\Http\Controllers\CashRegisterController::monthlyGross($month)['monthlyPayables'], 2) }}</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <h6 id="a-revenue">Annual Revenue</h6>
                                <h6 class="text-primary font-weight-bold" id="a-revenue-value">${{ number_format(\App\Http\Controllers\CashRegisterController::monthlyGross($month)['income'], 2) }}</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <h6 id="t-profit">Total Profit</h6>
                                <h6 class="text-success font-weight-bold" id="t-profit-value">$</h6>
                            </div>
                            <div class="col-md-3 text-center">
                                <h6 id="t-attrition">Attrition</h6>
                                <h6 class="text-danger font-weight-bold" id="t-attrition-value"></h6>
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

        var m = location.href.split('/');
        $(document).ready(function () {
            $('#selectMonth').val(m[5]);
            $('#selectYear').val(m.pop());
        })

        var d = new Date();
        var y = d.getFullYear();
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        @php $d = date('m'); 
            $attrition_fees = ($totalProfit['legal'] + $totalProfit['admin'] + $totalProfit['notary']) * .10;
            $attrition_commission = ($totalProfit['salesComm'] + $totalProfit['managementComm']) * .10;
            $monthly_sales = $totalProfit['income'];
            $sales = $totalProfit['income'] - ($totalProfit['income'] * .10);
            $fees = $totalProfit['payables'] - $attrition_commission;
            $profit = $sales - $fees;
            $attrition = ($monthly_sales * .10) + $attrition_commission;
        @endphp
        @if($month == 'annual' && $year == '2019')
        $('#a-report').text("Yearly Perspective");
        $('#t-profit').text("Total Sales");
        $('#a-revenue').text("Monthly Revenue");
        $('#a-fees').text("Fees to Date");
        $('#t-profit-value').text('$' + '{{ number_format($profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format($attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($fees, 2) }}')
        @php
            $currentYear = $totalProfit['totalDebt'];
            $prevYear = $totalProfit['totalDebt'];
            if($prevYear == 0){
                $ytd = 0;
            }else{
                $ytd = 0;
            }
        @endphp
        $('#ytd').text('{{number_format($ytd, 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        var annualData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', '2019'],
            datasets: [{
                label: 'Total Sales',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @php $d = date('m'); @endphp
                    @for($j = 1; $j < $d; $j++)
                    {{ $profit = 0 }},
                    @endfor
                    @for($k = $d; $k <= $d; $k++)
                    @php
                        $first = - $monthlyGross['monthlyPayables'];
                        $fifth = 0;
                    @endphp
                    {!! $first !!},
                    @endfor
                    @for($k = $d+1; $k <=$d+4; $k++)
                    @php
                        $fifth += ($monthlyGross['totalInc']) - $monthlyGross['legal'] - $monthlyGross['admin'];
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @php
                        $ytotal = ($monthlyGross['totalInc'] * (13-$d)) - $monthlyGross['monthlyPayables'] - (($monthlyGross['legal'] + $monthlyGross['admin']) * (4));
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
                    @for($j = 1; $j < $d; $j++)
                    {{ $profit = 0 }},
                    @endfor
                    @for($k = $d; $k <= $d; $k++)
                    @php
                        $first = 0;
                    @endphp
                    {!! $fifth = $first !!},
                    @endfor
                    @for($k = $d+1; $k <=12; $k++)
                    @php
                        $fifth += $monthlyGross['totalInc'];
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @php
                        $ytotal = ($monthlyGross['totalInc'] * (13-$d));
                    @endphp
                    {!! $ytotal !!},
                ],
            }, {
                label: 'Fees to Date',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($j = 1; $j < $d; $j++)
                    {{ $profit = 0 }},
                    @endfor
                    @for($k = $d; $k <= $d; $k++)
                    @php
                        $first = $monthlyGross['monthlyPayables'];
                    @endphp
                    {!! $first !!},
                    @endfor
                    @for($k = $d+1; $k <=12; $k++)
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
                    $d = date('m');
                    $current = \App\Http\Controllers\CashRegisterController::monthlyGross($d);
                    $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($d - 1);
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
                        text: 'Monthly Sales'
                    },
                    legend: {
                        display: false,
                    }
                }
            });
        }
        @elseif($month == 'annual' && $year == '2020')
        @php $d = date('m'); 
            $attrition_fees = ($totalProfit['legal'] + $totalProfit['admin'] + $totalProfit['notary']) * .10;
            $attrition_commission = ($totalProfit['salesComm'] + $totalProfit['managementComm']) * .10;
            $monthly_sales = $totalProfit['income'];
            $sales = $totalProfit['income'] - ($totalProfit['income'] * .10);
            $fees = $totalProfit['payables'] - $attrition_commission;
            $profit = $sales - $fees;
            $attrition = ($monthly_sales * .10) + $attrition_commission;
        @endphp
        $('#a-report').text("Yearly Perspective");
        $('#t-profit').text("Total Sales");
        $('#a-revenue').text("Monthly Revenue");
        $('#a-fees').text("Fees to Date");
        $('#t-profit-value').text('$' + '{{ number_format($profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format($attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($fees, 2) }}')
        @php
            $currentYear = $totalProfit['totalDebt'];
            $prevYear = $totalProfit['totalDebt'];
            if($prevYear == 0){
                $ytd = 0;
            }else{
                $ytd = 0;
            }
        @endphp
        $('#ytd').text('{{number_format($ytd, 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        var annualData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December','2020'],
            datasets: [{
                label: 'Total Sales',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @php
                        $d = date('m');
                        $profit = ($monthlyGross['totalInc'] * (13-$d)) - $monthlyGross['monthlyPayables'] - (($monthlyGross['admin'] + $monthlyGross['legal']) * 4);
                        $fees = 0;
                    @endphp
                    @for($j = 1; $j <= 1; $j++)
                    @php
                        $fees += $monthlyGross['legal'] + $monthlyGross['admin'];
                        $profit += $monthlyGross['totalInc'] - $monthlyGross['legal'] - $monthlyGross['admin'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($j = 2; $j <= 12; $j++)
                    @php
                        $fees += $monthlyGross['admin'];
                        $profit += $monthlyGross['totalInc'] - $monthlyGross['admin'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    @php
                        $ytotal = ($monthlyGross['totalInc'] * (12+(13-$d))) - $monthlyGross['monthlyPayables'] - (($monthlyGross['admin'] + $monthlyGross['legal']) * 4) - $fees;
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
                    @php
                        $d = date('m');
                        $profit = ($monthlyGross['totalInc'] * (13-$d));
                    @endphp
                    @for($j = 1; $j <= 1; $j++)
                    @php
                        $profit += $monthlyGross['totalInc'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($j = 2; $j <= 12; $j++)
                    @php
                        $profit += $monthlyGross['totalInc'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    {{ $profit }}
                ],
            }, {
                label: 'Fees to Date',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @php
                        $d = date('m');
                        $fees = 0;
                    @endphp
                    @for($j = 1; $j <= 1; $j++)
                    @php
                        $fee = $monthlyGross['legal'] + $monthlyGross['admin'];
                        $fees += $monthlyGross['legal'] + $monthlyGross['admin'];
                    @endphp
                    {{ $fee }},
                    @endfor
                    @for($j = 2; $j <= 12; $j++)
                    @php
                        $fee = $monthlyGross['admin'];
                        $fees += $monthlyGross['admin'];
                    @endphp
                    {{ $fee }},
                    @endfor
                    {{ $fees }}
                ],
            }]
        };

                @php
                    $d = date('m');
                    $current = \App\Http\Controllers\CashRegisterController::monthlyGross($d);
                    $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($d - 1);
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
                        text: 'Monthly Sales'
                    },
                    legend: {
                        display: false,
                    }
                }
            });
        }
        @elseif($year == '2021' && $month == 'annual')
        @php $d = date('m'); 
            $attrition_fees = ($totalProfit['legal'] + $totalProfit['admin'] + $totalProfit['notary']) * .10;
            $attrition_commission = ($totalProfit['salesComm'] + $totalProfit['managementComm']) * .10;
            $monthly_sales = $totalProfit['income'];
            $sales = $totalProfit['income'] - ($totalProfit['income'] * .10);
            $fees = $totalProfit['payables'] - $attrition_commission;
            $profit = $sales - $fees;
            $attrition = ($monthly_sales * .10) + $attrition_commission;
        @endphp
        $('#a-report').text("Yearly Perspective");
        $('#t-profit').text("Total Sales");
        $('#a-revenue').text("Monthly Revenue");
        $('#a-fees').text("Fees to Date");
        $('#t-profit-value').text('$' + '{{ number_format($profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format($attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($fees, 2) }}')
        @php
            $currentYear = $totalProfit['totalDebt'];
            $prevYear = $totalProfit['totalDebt'];
            if($prevYear == 0){
                $ytd = 0;
            }else{
                $ytd = 0;
            }
        @endphp
        $('#ytd').text('{{number_format($ytd, 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        var annualData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December','2021'],
            datasets: [{
                label: 'Total Sales',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @php
                        $d = date('m');
                        $num_of_months = (13-$d) + 12;
                        $profit = ($monthlyGross['totalInc'] * ($num_of_months)) - $monthlyGross['monthlyPayables'] - (($monthlyGross['admin'] * 17) + ($monthlyGross['legal'] * 5) );
                        $fees = 0;
                    @endphp
                    @for($j = $num_of_months+1; $j <= 22; $j++)
                    @php
                        $fees += $monthlyGross['admin'];
                        $profit += $monthlyGross['totalInc'] - $monthlyGross['admin'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($j = 23; $j <= 23; $j++)
                    @php
                        $fees += $monthlyGross['admin'];
                        $profit += $monthlyGross['totalInc'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($j = 23; $j <= 28; $j++)
                    @php
                        $fees += 0;
                        $profit += 0;
                        $excess = 0;
                    @endphp
                    {{ $excess }},
                    @endfor
                    {!! $profit !!},
                ],
                fill: true,
            }, {
                label: 'Monthly Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @php
                        $d = date('m');
                        $num_of_months = (13-$d) + 12;
                        $profit = ($monthlyGross['totalInc'] * ($num_of_months));
                        $fees = 0;
                    @endphp
                    @for($j = $num_of_months+1; $j <= 22; $j++)
                    @php
                        $fees += $monthlyGross['admin'];
                        $profit += $monthlyGross['totalInc'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($j = 23; $j <= 23; $j++)
                    @php
                        $fees += $monthlyGross['admin'];
                        $profit += $monthlyGross['totalInc'];
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($j = 23; $j <= 28; $j++)
                    @php
                        $fees += 0;
                        $profit += 0;
                        $excess = 0;
                    @endphp
                    {{ $excess }},
                    @endfor
                    {!! $profit !!},
                ],
            }, {
                label: 'Fees to Date',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @php
                        $d = date('m');
                        $num_of_months = (13-$d) + 12;
                        $profit = ($monthlyGross['totalInc'] * ($num_of_months));
                        $fees = 0;
                    @endphp
                    @for($j = $num_of_months+1; $j <= 22; $j++)
                    @php
                        $fee = $monthlyGross['admin'];
                        $fees += $monthlyGross['admin'];
                        $profit += $monthlyGross['totalInc'];
                    @endphp
                    {{ $fee }},
                    @endfor
                    @for($j = 22; $j <= 28; $j++)
                    @php
                        $fees += 0;
                        $profit += 0;
                        $excess = 0;
                    @endphp
                    {{ $excess }},
                    @endfor
                    {!! $fees !!},
                ],
            }]
        };

                @php
                    $d = date('m');
                    $current = \App\Http\Controllers\CashRegisterController::monthlyGross($d);
                    $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($d - 1);
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
                        text: 'Monthly Sales'
                    },
                    legend: {
                        display: false,
                    }
                }
            });
        }
                @else
        var month = months[{{$month}} - 1];
        if(month == '2019'){
            month = 'December'
        }
        $('#a-report').text(month+" Report");
        $('#t-profit').text(month+" Profit");
        $('#a-revenue').text(month+" Revenue");
        $('#a-fees').text(month+" Fees");
                @php
                    $grossIncome = \App\Http\Controllers\CashRegisterController::monthlyGross($month);
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
        var months_22 = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th',
                '11th', '12th', '13th', '14th', '15th', '16th', '17th', '18th', '19th', '20th', '21th', '22nd'];

        @if($year == '2019')
        $('#t-debt').text(months[{{$d}} - 1]+" Debt");
        $('#t-transactions').text(months[{{$d}} - 1]+" Transactions");
        $('#month-gross').text(months[{{$d}} - 1]+" Gross");
        $('#ytd-label').text(months[{{$d}} - 1]+" Growth");
        @php
            $m = date('m');
            $monthly = \App\Http\Controllers\CashRegisterController::monthlyGross($m);

            switch($month){
                case "1":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "2":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "3":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "4":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "5":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "6":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "7":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "8":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "9":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "10":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "11":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                case "12":
                    $d = date('m');
                    foreach($monthlies as $monthly){
                    $getMonth = explode('-', $monthly->month);
                        if($getMonth[1] == $month){
                            for($i = 1; $i <=1; $i++){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                            }
                            for($i = 2; $i <=6; $i++){
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales += $monthly->sales_lifetime;

                            }
                            for($i = 7; $i <=22; $i++){
                                $monthly_payables += $monthly->admin;
                                $sales += $monthly->sales_lifetime;
                            }
                            $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                            $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                            $monthly_payables = $monthly_payables - $attrition_commission;
                            $sales = $sales - ($sales * .10);
                            $profit = $sales - $monthly_payables;
                            $attrition = ($sales * .10) + $attrition_commission;
                        }
                    }
                break;
                default:
            }
        @endphp
        $('#t-profit-value').text('$' + '{{ number_format(!isset($profit) ? 0 : $profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format(!isset($attrition) ? 0 : $attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format(!isset($sales) ? 0 : $sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format(!isset($monthly_payables) ? 0 : $monthly_payables, 2) }}')
        $('#ytd').text('{{number_format($ytd, 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');

        @if($month <= date('m'))
        var monthlyData = {
            labels: months_22,
            datasets: [{
                label: '22-Months Profit',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @foreach($monthlies as $monthly)
                    @php
                        $getMonth = explode('-', $monthly->month);
                    @endphp
                    @if($getMonth[1] == $month)
                    @for($i = 1; $i <=1; $i++)
                    @php
                        $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm + $monthly->notary;
                        $sales = 0;
                        $profit = $sales - $monthly_payables;
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($i = 2; $i <=6; $i++)
                    @php
                        $monthly_payables = $monthly->legal + $monthly->admin;
                        $sales = $monthly->sales_lifetime;
                        $profit = $sales - $monthly_payables;
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($i = 7; $i <=22; $i++)
                    @php
                        $monthly_payables = $monthly->admin;
                        $sales = $monthly->sales_lifetime;
                        $profit = $sales - $monthly_payables;
                    @endphp
                    {{ $profit }},
                    @endfor
                    @for($i = 23; $i <=23; $i++)
                    @php
                        $sales = $monthly->sales_lifetime;
                    @endphp
                    {{ $sales }},
                    @endfor
                    @endif
                    @endforeach
                ],
                fill: true,
            }, {
                label: '22-Months Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @foreach($monthlies as $monthly)
                    @php
                        $getMonth = explode('-', $monthly->month);
                    @endphp
                    @if($getMonth[1] == $month)
                    @for($i = 1; $i <=1; $i++)
                    @php
                        $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm  + $monthly->notary;
                        $sales = 0;
                        $profit = 0;
                    @endphp
                    {{ $sales }},
                    @endfor
                    @for($i = 2; $i <=6; $i++)
                    @php
                        $monthly_payables = $monthly->legal + $monthly->admin;
                        $sales = $monthly->sales_lifetime;
                        $profit = $sales - $monthly_payables;
                    @endphp
                    {{ $sales }},
                    @endfor
                    @for($i = 7; $i <=22; $i++)
                    @php
                        $monthly_payables = $monthly->admin;
                        $sales = $monthly->sales_lifetime;
                        $profit = $sales - $monthly_payables;
                    @endphp
                    {{ $sales }},
                    @endfor
                    @for($i = 23; $i <=23; $i++)
                    @php
                        $sales = $monthly->sales_lifetime;
                    @endphp
                    {{ $sales }},
                    @endfor
                    @endif
                    @endforeach
                ],
            }, {
                label: '22-Months Fees',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @foreach($monthlies as $monthly)
                    @php
                        $getMonth = explode('-', $monthly->month);
                    @endphp
                    @if($getMonth[1] == $month)
                    @for($i = 1; $i <=1; $i++)
                    @php
                        $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm + $monthly->notary;
                        $sales = 0;
                        $profit = 0;
                    @endphp
                    {{ $monthly_payables }},
                    @endfor
                    @for($i = 2; $i <=6; $i++)
                    @php
                        $monthly_payables = $monthly->legal + $monthly->admin;
                        $sales = $monthly->sales_lifetime;
                        $profit = $sales - $monthly_payables;
                    @endphp
                    {{ $monthly_payables }},
                    @endfor
                    @for($i = 7; $i <=22; $i++)
                    @php
                        $monthly_payables = $monthly->admin;
                        $sales = $monthly->sales_lifetime;
                        $profit = $sales - $monthly_payables;
                    @endphp
                    {{ $monthly_payables }},
                    @endfor

                    @for($i = 23; $i <=23; $i++)
                    @php
                        $sales = $monthly->sales_lifetime;
                    @endphp
                    {{ $sales }},
                    @endfor
                    @endif
                    @endforeach
                ],
            }]
        };

                @php
                    $m = date('m');
                    $grossIncome = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                @endphp
        var analysisConfig = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [
                            @foreach($monthlies as $monthly)
                            @php
                                $getMonth = explode('-', $monthly->month);
                            @endphp
                            @if($getMonth[1] == $month)
                            @for($i = 1; $i <=1; $i++)
                            @php
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                $sales = $monthly->sales_lifetime;
                                $profit = $sales - $monthly_payables;
                                $monthly_legal = $monthly->legal;
                                $monthly_admin = $monthly->admin;
                                $monthly_notary = $monthly->notary;
                                $monthly_sales_comm = $monthly->sales_comm;
                                $monthly_admin_comm = $monthly->admin_comm;
                            @endphp
                            @endfor
                            @for($i = 2; $i <=6; $i++)
                            @php
                                $monthly_payables += $monthly->legal + $monthly->admin;
                                $sales = $monthly->sales_lifetime;
                                $profit = $sales - $monthly_payables;
                            @endphp
                            @endfor
                            @for($i = 7; $i <=22; $i++)
                            @php
                                $monthly_payables += $monthly->admin;
                                $sales = $monthly->sales_lifetime;
                                $profit = $sales - $monthly_payables;
                            @endphp
                            @endfor
                            @endif
                            @endforeach
                            {{ round(!isset($monthly_notary) ? 0 : $monthly_notary,2) }},
                            {{ round(!isset($monthly_legal) ? 0 : $monthly_legal,2) }},
                            {{ round(!isset($monthly_admin) ? 0 : $monthly_admin,2) }},
                            {{ round(!isset($monthly_sales_comm) ? 0 : $monthly_sales_comm,2) }},
                            {{ round(!isset($monthly_admin_comm) ? 0 : $monthly_admin_comm,2) }},
                            {{ round(!isset($sales) ? 0 : $sales,2) }},
                        ],
                        backgroundColor: [
                            'rgba(255, 255, 0, 0.3)',
                            'rgba(255, 255, 0, 0.4)',
                            'rgba(255, 255, 0, 0.5)',
                            'rgba(255, 255, 0, 0.6)',
                            'rgba(255, 255, 0, 0.7)',
                            'rgba(0, 0, 255, 0.4)'
                        ],
                    }],
                    labels: [
                        'Monthly Notary Fee',
                        'Monthly Legal Fee',
                        'Monthly Admin Fee',
                        'Monthly Sales Commission Fee',
                        'Monthly Management Commission Fee',
                        'Monthly Income',
                    ]
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

        @else
        @php
            $m = 13 - date('m');
            $monthly_payables = 0;
            $monthly_sales = 0;

                foreach($monthlies as $monthly){
                    $monthly_payables += $monthly->legal + $monthly->admin;
                    $monthly_sales += $monthly->sales_lifetime;
                    $profit = $monthly_sales - $monthly_payables;
                }
                    $attrition_fees = ($monthly->legal + $monthly->admin + $monthly->notary) * .10;
                    $attrition_commission = ($monthly->sales_comm + $monthly->admin_comm) * .10;
                    $monthly_sales = $monthly_sales - ($monthly_sales * .10);
                    $profit = $monthly_sales - $monthly_payables;
                    $attrition = ($monthly_sales * .10);
        @endphp
        $('#t-profit-value').text('$' + '{{ number_format(!isset($profit) ? 0 : $profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format(!isset($attrition) ? 0 : $attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format(!isset($monthly_sales) ? 0 : $monthly_sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format(!isset($monthly_payables) ? 0 : $monthly_payables, 2) }}')
        var monthlyData = {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [
                            @foreach($monthlies as $monthly)
                            @php
                                $getMonth = explode('-', $monthly->month);
                                $m = 13 - $getMonth[1];

                                if($m == 1){
                                    $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                }else if($m <= 6 ){
                                    $monthly_payables = $monthly->legal + $monthly->admin;
                                }else if($m > 6){
                                    $monthly_payables = $monthly->admin;
                                }
                            @endphp
                            {{ $monthly->sales_lifetime - $monthly_payables }},
                            {{ $monthly->sales_lifetime }},
                            {{ $monthly_payables }},
                            @endforeach
                        ],
                        backgroundColor: [
                            @foreach($monthlies as $monthly)
                                'rgba(0, 255, 0, 0.3)',
                            'rgba(0, 0, 255, 0.3)',
                            'rgba(255, 255, 0, 0.3)',
                            @endforeach
                        ],
                        label: 'Monthly Revenue'
                    }],
                    labels: [
                        @php
                            $months = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                        @endphp
                                @foreach($monthlies as $monthly)
                                @php
                                    $getMonth = explode('-', $monthly->month);
                                    $month = $months[ltrim($getMonth[1], '0')];
                                @endphp
                            '{{ $month }} Profit',
                        '{{ $month }} Sales',
                        '{{ $month }} Fees',
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Doughnut Chart'
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            };
                @php
                    $m = date('m');
                    $grossIncome = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                @endphp
        var analysisConfig = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [
                            @for($j = 1; $j <=1; $j++)
                            @php
                                $aIncome = $grossIncome['totalInc'];
                                $aFees = $grossIncome['monthlyPayables'];
                            @endphp
                            @endfor
                            @for($k = 2; $k <=6; $k++)
                            @php
                                $aIncome += $grossIncome['totalInc'];
                                $aFees += $grossIncome['legal'] + $grossIncome['admin'];
                            @endphp
                            @endfor
                            @for($l = 7; $l <=22; $l++)
                            @php
                                $aIncome += $grossIncome['totalInc'];
                                $aFees += $grossIncome['admin'];
                            @endphp
                            @endfor
                            {!! $aFees !!},
                            {!! $aIncome !!},
                        ],
                        backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                        // label: 'Dataset 1'
                    }],
                    labels: [
                        'Accumulated Fees',
                        'Accumulated Income',
                    ]
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
        @endif

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

            @if($month <= date('m'))
                var myChart = new Chart(context, {
                    type: 'bar',
                    data: monthlyData,
                    options: {
                        responsive: true,
                        title: {
                            display: false,
                            text: 'Annual Report'
                        },
                        legend: {
                            display: true,
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            xAxes: [{
                                stacked: true,
                            }],
                            yAxes: [{
                                stacked: true
                            }]
                        }
                    }
                });
            @else
                var myChart = new Chart(context, monthlyData);
            @endif

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
        @elseif($year == '2020')
        @php
            $monthly_payables = 0;
            $monthly_sales = 0;

            foreach($monthlies as $monthly){
                $getMonth = explode('-', $monthly->month);
                $m = 13 - $getMonth[1] + $month;
                if($m > 6){
                    $monthly_payables += $monthly->admin;
                }else{
                    $monthly_payables += $monthly->legal + $monthly->admin;
                }
                $monthly_sales += $monthly->sales_lifetime;
            }
            
            $monthly_sales = $monthly_sales - ($monthly_sales * .10);
            $profit = $monthly_sales - $monthly_payables;
            $attrition = ($monthly_sales * .10);
        @endphp
        $('#t-profit-value').text('$' + '{{ number_format($profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format($attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($monthly_sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($monthly_payables, 2) }}')
        $('#ytd').text('{{number_format('0', 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        $('#t-debt').text(months[{{$d}} - 1]+" Debt");
        $('#t-transactions').text(months[{{$d}} - 1]+" Transactions");
        $('#month-gross').text(months[{{$d}} - 1]+" Gross");
        $('#ytd-label').text(months[{{$d}} - 1]+" Growth");

        var monthlyData = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        @foreach($monthlies as $monthly)
                            @php
                                $getMonth = explode('-', $monthly->month);
                                $m = 13 - $getMonth[1] + $month;

                                if($m == 1){
                                    $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                                }else if($m <= 6 ){
                                    $monthly_payables = $monthly->legal + $monthly->admin;
                                }else if($m > 6){
                                    $monthly_payables = $monthly->admin;
                                }
                            @endphp
                        {{ $monthly->sales_lifetime - $monthly_payables }},
                        {{ $monthly->sales_lifetime }},
                        {{ $monthly_payables }},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($monthlies as $monthly)
                            'rgba(0, 255, 0, 0.3)',
                            'rgba(0, 0, 255, 0.3)',
                            'rgba(255, 255, 0, 0.3)',
                        @endforeach
                    ],
                    label: 'Monthly Revenue'
                }],
                labels: [
                    @php
                        $months = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    @endphp
                    @foreach($monthlies as $monthly)
                        @php
                            $getMonth = explode('-', $monthly->month);
                            $month = $months[ltrim($getMonth[1], '0')];
                        @endphp
                        '{{ $month }} Profit',
                        '{{ $month }} Sales',
                        '{{ $month }} Fees',
                    @endforeach
                ]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: false,
                    text: 'Chart.js Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };
                @php
                    $m = date('m');
                    $grossIncome = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                @endphp
        var analysisConfig = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [
                            @for($j = 1; $j <=1; $j++)
                            @php
                                $aIncome = $grossIncome['totalInc'];
                                $aFees = $grossIncome['monthlyPayables'];
                            @endphp
                            @endfor
                            @for($k = 2; $k <=6; $k++)
                            @php
                                $aIncome += $grossIncome['totalInc'];
                                $aFees += $grossIncome['legal'] + $grossIncome['admin'];
                            @endphp
                            @endfor
                            @for($l = 7; $l <=22; $l++)
                            @php
                                $aIncome += $grossIncome['totalInc'];
                                $aFees += $grossIncome['admin'];
                            @endphp
                            @endfor
                            {!! $aFees !!},
                            {!! $aIncome !!},
                        ],
                        backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                        // label: 'Dataset 1'
                    }],
                    labels: [
                        'Accumulated Fees',
                        'Accumulated Income',
                    ]
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
            var myChart = new Chart(context, monthlyData);

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
        @elseif($year == '2021')
        @php
            $monthly_payables = 0;
            $monthly_sales = 0;

            foreach($monthlies as $monthly){
                $getMonth = explode('-', $monthly->month);
                $m = (12 - $getMonth[1]) + 12 + $month;

                $monthly_payables += $monthly->admin;
                $monthly_sales += $monthly->sales_lifetime;

                $monthly_sales = $monthly_sales - ($monthly_sales * .10);
                $profit = $monthly_sales - $monthly_payables;
                $attrition = ($monthly_sales * .10);

                if($m > 22){
                    $monthly_payables = 0;
                    $monthly_sales = 0;
                    $profit = 0;
                }
            }
        @endphp
        $('#t-debt').text(months[{{$d}} - 1]+" Debt");
        $('#t-transactions').text(months[{{$d}} - 1]+" Transactions");
        $('#month-gross').text(months[{{$d}} - 1]+" Gross");
        $('#ytd-label').text(months[{{$d}} - 1]+" Growth");
        $('#t-profit-value').text('$' + '{{ number_format($profit, 2) }}')
        $('#t-attrition-value').text('$' + '{{ number_format($attrition, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($monthly_sales, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($monthly_payables, 2) }}')
        $('#ytd').text('{{number_format('0', 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        var monthlyData = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        @foreach($monthlies as $monthly)
                        @php
                            $getMonth = explode('-', $monthly->month);
                            $m = (12 - $getMonth[1]) + 12 + $month;

                            if($m == 1){
                                $monthly_payables = $monthly->legal + $monthly->admin + $monthly->sales_comm + $monthly->admin_comm;
                            }else if($m <= 6 ){
                                $monthly_sales = $monthly->sales_lifetime;
                                $monthly_payables = $monthly->legal + $monthly->admin;
                            }else if($m > 6 && $m < 23){
                                $monthly_sales = $monthly->sales_lifetime;
                                $monthly_payables = $monthly->admin;
                            }else if($m > 22){
                                $monthly_payables = 0;
                                $monthly_sales = 0;
                            }
                        @endphp
                        {{ $monthly_sales - $monthly_payables }},
                        {{ $monthly_sales }},
                        {{ $monthly_payables }},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach($monthlies as $monthly)
                            'rgba(0, 255, 0, 0.3)',
                            'rgba(0, 0, 255, 0.3)',
                            'rgba(255, 255, 0, 0.3)',
                        @endforeach
                    ],
                    label: 'Monthly Revenue'
                }],
                labels: [
                    @php
                        $months = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    @endphp
                            @foreach($monthlies as $monthly)
                            @php
                                $getMonth = explode('-', $monthly->month);
                                $month = $months[ltrim($getMonth[1], '0')];
                            @endphp
                        '{{ $month }} Profit',
                        '{{ $month }} Sales',
                        '{{ $month }} Fees',
                    @endforeach
                ]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: false,
                    text: 'Chart.js Doughnut Chart'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };
                @php
                    $m = date('m');
                    $grossIncome = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                @endphp
        var analysisConfig = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [
                            @for($j = 1; $j <=1; $j++)
                            @php
                                $aIncome = $grossIncome['totalInc'];
                                $aFees = $grossIncome['monthlyPayables'];
                            @endphp
                            @endfor
                            @for($k = 2; $k <=6; $k++)
                            @php
                                $aIncome += $grossIncome['totalInc'];
                                $aFees += $grossIncome['legal'] + $grossIncome['admin'];
                            @endphp
                            @endfor
                            @for($l = 7; $l <=22; $l++)
                            @php
                                $aIncome += $grossIncome['totalInc'];
                                $aFees += $grossIncome['admin'];
                            @endphp
                            @endfor
                            {!! $aFees !!},
                            {!! $aIncome !!},
                        ],
                        backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                        // label: 'Dataset 1'
                    }],
                    labels: [
                        'Accumulated Fees',
                        'Accumulated Income',
                    ]
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
            var myChart = new Chart(context, monthlyData);

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
                @endif


        @endif
    </script>
@endsection

