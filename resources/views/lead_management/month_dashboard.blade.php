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
                            <span>Total Debt</span>
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
                            <span>Total Transactions</span>
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
                            <span>Monthly Gross</span>
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
                                <select id="selectYear" class="d-none" style="border-radius: 5px">
                                    <option selected value="2019" id="year">2019</option>
                                    <option value="2020" class="year">2020</option>
                                    <option value="2021" class="year">2021</option>
                                </select>
                                <select id="selectMonth" class="d-none" style="border-radius: 5px">
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
                                <select id="selectProjection" style="border-radius: 5px">
                                    <option selected value="monthOnly" class="projection">Month Only</option>
                                    <option value="yearOnly" class="projection">Year Only</option>
                                    <option value="monthAndYear" class="projection">Month and Year</option>
                                </select>
                                <button class="btn btn-primary btn-sm" id="search-m">search</button>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div class="row mb-5">
                            <div class="col-md-4 text-center">
                                <h6 id="a-fees">Annual Fees</h6>
                                <h5 class="text-warning font-weight-bold" id="a-fees-value">${{ number_format(\App\Http\Controllers\CashRegisterController::monthlyGross($month)['monthlyPayables'], 2) }}</h5>
                            </div>
                            <div class="col-md-4 text-center">
                                <h6 id="a-revenue">Annual Revenue</h6>
                                <h5 class="text-primary font-weight-bold" id="a-revenue-value">${{ number_format(\App\Http\Controllers\CashRegisterController::monthlyGross($month)['income'], 2) }}</h5>
                            </div>
                            <div class="col-md-4 text-center">
                                <h6 id="t-profit">Total Profit</h6>
                                <h5 class="text-success font-weight-bold" id="t-profit-value">${{ number_format(\App\Http\Controllers\CashRegisterController::monthlyGross($month)['profit'], 2) }}</h5>
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
                            <span style="font-size: 10px;">{!! $mGrowth !!}% High than last month</span>
                        </div>
                        <canvas id="analysis-graph"></canvas>
                    </div>
                </div>
                <div class="card pb-3 pr-3 pl-3">
                    <div class="row">
                        <div class="header">
                            <h2>Monthly Income</h2>
                            <span style="font-size: 10px;">Overall: <strong> ${{ number_format(\App\Http\Controllers\CashRegisterController::monthlyGross($m)['income'], 2) }}</strong></span>
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
        $('#selectProjection').on('change', function () {
            var id = $(this).val();
            if(id == 'monthOnly'){
                $('#selectMonth').removeClass('d-none');
                $('#selectYear').addClass('d-none');
                $('#search-m').on('click', function () {
                    var sMonth = $('#selectMonth').val();
                    location.href = '/sales-projection/month/'+ sMonth + "/2019";
                })
            }
            else if(id == 'yearOnly'){
                $('#selectMonth').addClass('d-none');
                $('#selectYear').removeClass('d-none');
                $('#search-m').on('click', function () {
                    var sYear = $('#selectYear').val();
                    location.href = '/sales-projection/month/annual' + "/" + sYear;
                })
            }else{
                $('#selectMonth').removeClass('d-none');
                $('#selectYear').removeClass('d-none');
                $('#search-m').on('click', function () {
                    var sMonth = $('#selectMonth').val();
                    var sYear = $('#selectYear').val();
                    location.href = '/sales-projection/month/' + sMonth + "/" + sYear;
                })
            }
        })

        var m = location.href.split('/');
        $(document).ready(function () {
            $('#selectMonth').val(m[5]);
            $('#selectYear').val(m.pop());
        })

        var d = new Date();
        var y = d.getFullYear();
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', y];

        @if($month == 'annual' && $year == '2019')
            $('#a-report').text("Yearly Perspective");
            $('#t-profit').text("Total Sales");
            $('#a-revenue').text("Monthly Revenue");
            $('#a-fees').text("Fees to Date");
            $('#t-profit-value').text('$' + '{{ number_format($totalProfit['profit'], 2) }}')
            $('#a-revenue-value').text('$' + '{{ number_format($totalProfit['income'], 2) }}')
            $('#a-fees-value').text('$' + '{{ number_format($totalProfit['payables'], 2) }}')
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
                    @for($i = 1; $i <= 12; $i++)
                        @if($i == 1)
                            @php
                                $jan = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $janP = $jan['mprofit'];
                                $janL = $jan['legal'];
                                $janA = $jan['admin'];
                                $janI = $jan['income'];
                            @endphp
                        {{ $janP }},
                        @elseif($i == 2)
                            @php
                                $feb = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $febP = $feb['mprofit'];
                                $febL = $feb['legal'];
                                $febA = $feb['admin'];
                                $febI = $feb['income'];
                                $pay = $janL + $janA;
                                $mtotal = $febP - $pay + ($janI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 3)
                            @php
                                $mar = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $marP = $mar['mprofit'];
                                $marL = $mar['legal'];
                                $marA = $mar['admin'];
                                $marI = $mar['income'];
                                $pay += $febL + $febA;
                                $mtotal = $marP - $pay + ($janI * 3) + ($febI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 4)
                            @php
                                $apr = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $aprP = $apr['mprofit'];
                                $aprL = $apr['legal'];
                                $aprA = $apr['admin'];
                                $aprI = $apr['income'];
                                $pay += $marL + $marA;
                                $mtotal = $aprP - $pay + ($janI * 4) + ($febI * 3) + ($marI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 5)
                            @php
                                $may = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $mayP = $may['mprofit'];
                                $mayL = $may['legal'];
                                $mayA = $may['admin'];
                                $mayI = $may['income'];
                                $pay += $aprL + $aprA;
                                $mtotal = $mayP - $pay + ($janI * 5) + ($febI * 4) + ($marI * 3) + ($aprI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 6)
                            @php
                                $jun = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $junP = $jun['mprofit'];
                                $junL = $jun['legal'];
                                $junA = $jun['admin'];
                                $junI = $jun['income'];
                                $mtotal = $junP - $janA - $febL - $febA - $marL - $marA - $aprL - $aprA - $mayL - $mayA
                                + ($janI * 6) + ($febI * 5) + ($marI * 4) + ($aprI * 3) + ($mayI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 7)
                            @php
                                $jul = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $julP = $jul['mprofit'];
                                $julL = $jul['legal'];
                                $julA = $jul['admin'];
                                $julI = $jul['income'];
                                $mtotal = $julP - $janA - $febA - $marL - $marA - $aprL - $aprA - $mayL - $mayA - $junL - $junA
                                + ($janI * 6) + ($febI * 6) + ($marI * 5) + ($aprI * 4) + ($mayI * 3) + ($junI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 8)
                            @php
                                $aug = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $augP = $aug['mprofit'];
                                $augL = $aug['legal'];
                                $augA = $aug['admin'];
                                $augI = $aug['income'];
                                $mtotal = $augP - $janA - $febA - $marA - $aprL - $aprA - $mayL - $mayA - $junL - $junA - $julL - $julA
                                + ($janI * 8) + ($febI * 7) + ($marI * 6) + ($aprI * 5) + ($mayI * 4) + ($junI * 3) + ($julI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 9)
                            @php
                                $sep = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $sepP = $sep['mprofit'];
                                $sepL = $sep['legal'];
                                $sepA = $sep['admin'];
                                $sepI = $sep['income'];
                                $mtotal = $sepP - $janA - $febA - $marA - $aprA - $mayL - $mayA - $junL - $junA - $julL - $julA - $augL - $augA
                                + ($janI * 9) + ($febI * 8) + ($marI * 7) + ($aprI * 6) + ($mayI * 5) + ($junI * 4) + ($julI * 3) + ($augI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 10)
                            @php
                                $oct = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $octP = $oct['mprofit'];
                                $octL = $oct['legal'];
                                $octA = $oct['admin'];
                                $octI = $oct['income'];
                                $mtotal = $octP - $janA - $febA - $marA - $aprA - $mayA - $junL - $junA - $julL - $julA - $augL - $augA - $sepL - $sepA
                                + ($janI * 10) + ($febI * 9) + ($marI * 8) + ($aprI * 7) + ($mayI * 6) + ($junI * 5) + ($julI * 4) + ($augI * 3) + ($sepI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 11)
                            @php
                                $nov = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $novP = $nov['mprofit'];
                                $novL = $nov['legal'];
                                $novA = $nov['admin'];
                                $novI = $nov['income'];
                                $mtotal = $novP - $janA - $febA - $marA - $aprA - $mayA - $junA - $julL - $julA - $augL - $augA - $sepL - $sepA - $octL - $octA
                                + ($janI * 11) + ($febI * 10) + ($marI * 9) + ($aprI * 8) + ($mayI * 7) + ($junI * 6) + ($julI * 5) + ($augI * 4) + ($sepI * 3) + ($octI * 2);
                            @endphp
                        {{ $mtotal }},
                        @elseif($i == 12)
                            @php
                                $dec = \App\Http\Controllers\CashRegisterController::monthlyGross($i);
                                $decP = $dec['mprofit'];
                                $decL = $dec['legal'];
                                $decA = $dec['admin'];
                                $decI = $dec['income'];
                                $mtotal = $decP - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augL - $augA - $sepL - $sepA - $octL - $octA - $novL - $novA
                            + ($janI * 12) + ($febI * 11) + ($marI * 10) + ($aprI * 9) + ($mayI * 8) + ($junI * 7) + ($julI * 6) + ($augI * 5) + ($sepI * 4) + ($octI * 3) + ($novI * 2);
                            @endphp
                        {{ $mtotal }},
                        @endif
                    @endfor
                    @php
                        $ytotal = ($janI * 12) + ($febI * 11) + ($marI * 10) + ($aprI * 9) + ($mayI * 8) + ($junI * 7) + ($julI * 6) + ($augI * 5) + ($sepI * 4) + ($octI * 3) + ($novI * 2) +
                        $decP - $janL - $janA - $febL - $febA - $marL - $marA - $aprL - $aprA - $mayL - $mayA - $junL - $junA - $julL - $julA - $augL - $augA - $sepL - $sepA - $octL - $octA - $novL - $novA
                        - $jan['monthlyPayables'] - $feb['monthlyPayables'] - $mar['monthlyPayables'] - $apr['monthlyPayables'] - $may['monthlyPayables'] - $jun['monthlyPayables']
                        - $jul['monthlyPayables'] - $aug['monthlyPayables'] - $sep['monthlyPayables'] - $oct['monthlyPayables'] - $nov['monthlyPayables'];
                    @endphp
                    {{ $ytotal }}
                ],
                fill: true,
            }, {
                label: 'Monthly Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @php
                        $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                        $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                        $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                        $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                        $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                        $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                        $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                        $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                        $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                        $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                        $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                        $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                    @endphp

                    @php
                        $profit1 = $jan['income'];

                        $profit2 = $feb['income'] + ($jan['income'] * 2);

                        $profit3 = $mar['income'] + ($jan['income'] * 3)
                         + ($feb['income'] * 2);

                        $profit4 = $apr['income'] + ($jan['income'] * 4)+ ($feb['income'] * 3)+ ($mar['income'] * 2);

                        $profit5 = $may['income'] + ($jan['income'] * 5)
                        + ($feb['income'] * 4)+ ($mar['income'] * 3)+ ($apr['income'] * 2);

                        $profit6 = $jun['income'] + ($jan['income'] * 6)
                        + ($feb['income'] * 5)+ ($mar['income'] * 4)+ ($apr['income'] * 3)+ ($may['income'] * 2);

                        $profit7 = $jul['income'] + ($jan['income'] * 7)
                        + ($feb['income'] * 6)+ ($mar['income'] * 5)+ ($apr['income'] * 4)+ ($may['income'] * 3)+ ($jun['income'] * 2);

                        $profit8 = $aug['income'] + ($jan['income'] * 8)+ ($feb['income'] * 7)+ ($mar['income'] * 6)+ ($apr['income'] * 5)+ ($may['income'] * 4)
                        + ($jun['income'] * 3)+ ($jul['income'] * 2);

                        $profit9 = $sep['income'] + ($jan['income'] * 9)+ ($feb['income'] * 8)+ ($mar['income'] * 7)+ ($apr['income'] * 6)+ ($may['income'] * 5)
                        + ($jun['income'] * 4)+ ($jul['income'] * 3)+ ($aug['income'] * 2);

                        $profit10 = $oct['income'] + ($jan['income'] * 10)+ ($feb['income'] * 9)+ ($mar['income'] * 8)+ ($apr['income'] * 7)+ ($may['income'] * 6)
                        + ($jun['income'] * 5)+ ($jul['income'] * 4)+ ($aug['income'] * 3)+ ($sep['income'] * 2);

                        $profit11 = $nov['income'] + ($jan['income'] * 11)+ ($feb['income'] * 10)+ ($mar['income'] * 9)+ ($apr['income'] * 8)+ ($may['income'] * 7)
                        + ($jun['income'] * 6)+ ($jul['income'] * 5)+ ($aug['income'] * 4)+ ($sep['income'] * 3)+ ($oct['income'] * 2);

                        $profit12 = $dec['income'] + ($jan['income'] * 12)+ ($feb['income'] * 11)+ ($mar['income'] * 10)+ ($apr['income'] * 9)+ ($may['income'] * 8)
                        + ($jun['income'] * 7)+ ($jul['income'] * 6)+ ($aug['income'] * 5)+ ($sep['income'] * 4)+ ($oct['income'] * 3)+ ($nov['income'] * 2);

                        $ytotal = ($janI * 12) + ($febI * 11) + ($marI * 10) + ($aprI * 9) + ($mayI * 8) + ($junI * 7) + ($julI * 6) + ($augI * 5) + ($sepI * 4) + ($octI * 3) + ($novI * 2) + $decP;
                    @endphp
                    {{ $profit1 }},
                    {{ $profit2 }},
                    {{ $profit3 }},
                    {{ $profit4 }},
                    {{ $profit5 }},
                    {{ $profit6 }},
                    {{ $profit7 }},
                    {{ $profit8 }},
                    {{ $profit9 }},
                    {{ $profit10 }},
                    {{ $profit11 }},
                    {{ $profit12 }},
                    {{ $ytotal }},
                ],
            }, {
                label: 'Fees to Date',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @php
                        $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                        $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                        $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                        $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                        $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                        $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                        $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                        $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                        $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                        $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                        $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                        $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                    @endphp

                    @php
                        $profit1 = $jan['monthlyPayables'];

                        $profit2 = $feb['monthlyPayables'] + $jan['legal'] + $jan['admin'];

                        $profit3 = $mar['monthlyPayables'] + $jan['legal'] + $jan['admin'] + $feb['legal'] + $feb['admin'];

                        $profit4 = $apr['monthlyPayables'] + $jan['legal'] + $jan['admin'] +
                        $feb['legal'] + $feb['admin'] + $mar['legal'] + $mar['admin'];

                        $profit5 = $may['monthlyPayables'] + $jan['legal'] + $jan['admin'] +
                        $feb['legal'] + $feb['admin'] + $mar['legal'] + $mar['admin'] + $apr['legal'] + $apr['admin'];

                        $profit6 = $jun['monthlyPayables'] + $jan['admin'] + $feb['legal'] + $feb['admin'] +
                        $mar['legal'] + $mar['admin'] + $apr['legal'] + $apr['admin'] + $may['legal'] + $may['admin'];

                        $profit7 = $jul['monthlyPayables'] + $jan['admin'] + $feb['admin'] + $mar['legal'] + $mar['admin'] +
                        $apr['legal'] + $apr['admin'] + $may['legal'] + $may['admin'] + $jun['legal'] + $jun['admin'];

                        $profit8 = $aug['monthlyPayables'] + $jan['admin'] + $feb['admin'] + $mar['admin'] +
                        $apr['legal'] + $apr['admin'] + $may['legal'] + $may['admin'] + $jun['legal'] + $jun['admin'] +
                        $jul['legal'] + $jul['admin'];

                        $profit9 = $sep['monthlyPayables'] + $jan['admin'] + $feb['admin'] + $mar['admin'] + $apr['admin'] +
                        $may['legal'] + $may['admin'] + $jun['legal'] + $jun['admin'] + $jul['legal'] + $jul['admin'] +
                        $aug['legal'] + $aug['admin'];

                        $profit10 = $oct['monthlyPayables'] + $jan['admin'] + $feb['admin'] + $mar['admin'] + $apr['admin'] + $may['admin'] +
                        $jun['legal'] + $jun['admin'] + $jul['legal'] + $jul['admin'] + $aug['legal'] + $aug['admin'] +
                        $sep['legal'] + $sep['admin'];

                        $profit11 = $nov['monthlyPayables'] + $jan['admin'] + $feb['admin'] + $mar['admin'] + $apr['admin'] + $may['admin'] +
                        $jun['admin'] + $jul['legal'] + $jul['admin'] + $aug['legal'] + $aug['admin'] + $sep['legal'] + $sep['admin'] +
                        $oct['legal'] + $oct['admin'];

                        $profit12 = $dec['monthlyPayables'] + $jan['admin'] + $feb['admin'] + $mar['admin'] + $apr['admin'] + $may['admin'] +
                        $jun['admin'] + $jul['admin'] + $aug['legal'] + $aug['admin'] + $sep['legal'] + $sep['admin'] + $oct['legal'] + $oct['admin'] +
                        $nov['legal'] + $nov['admin'];

                        $ytotal = $dec['monthlyPayables'] + $jan['monthlyPayables'] + $feb['monthlyPayables'] + $mar['monthlyPayables'] + $apr['monthlyPayables'] + $may['monthlyPayables'] +
                        $jun['monthlyPayables'] + $jul['monthlyPayables'] + $aug['monthlyPayables'] + $sep['monthlyPayables'] + $oct['monthlyPayables'] +
                        $nov['monthlyPayables'] + $jan['admin'] + $feb['legal'] + $feb['admin'] +
                        $mar['legal'] + $mar['admin'] + $apr['legal'] + $apr['admin'] + $may['legal'] + $may['admin'] +
                        $jun['legal'] + $jun['admin'] + $jul['legal'] + $jul['admin'] + $aug['legal'] + $aug['admin'] + $sep['legal'] + $sep['admin'] + $oct['legal'] + $oct['admin'] +
                        $nov['legal'] + $nov['admin'];
                    @endphp
                    {{ $profit1 }},
                    {{ $profit2 }},
                    {{ $profit3 }},
                    {{ $profit4 }},
                    {{ $profit5 }},
                    {{ $profit6 }},
                    {{ $profit7 }},
                    {{ $profit8 }},
                    {{ $profit9 }},
                    {{ $profit10 }},
                    {{ $profit11 }},
                    {{ $profit12 }},
                    {{ $ytotal }},
                ],
            }]
        };

        var analysis = {
            @php
                $m = date('m');
                $current = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($m - 1);
            @endphp
            datasets: [{
                label: ['Previous Month', 'Current Month'],
                backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                data: [
                    @php
                        $prev = $previous['income'];
                        $now = $current['income'];
                    @endphp
                    {!! $prev !!},
                    {!! $now !!}
                ],
                fill: true,
            }]
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
            var myChart = new Chart(contextAnalysis, {
                type: 'pie',
                data: analysis,
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
        $('#a-report').text("Yearly Perspective");
        $('#t-profit').text("Total Sales");
        $('#a-revenue').text("Monthly Revenue");
        $('#a-fees').text("Fees to Date");
        $('#t-profit-value').text('$' + '{{ number_format($totalProfit['profit'], 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($totalProfit['income'], 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($totalProfit['payables'], 2) }}')
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
                    @for($i = 1; $i <= 12; $i++)
                    @if($i == 1)
                    @php
                        $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                        $janP = $jan['mprofit'];
                        $janL = $jan['legal'];
                        $janA = $jan['admin'];
                        $janI = $jan['income'];
                        $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                        $febP = $feb['mprofit'];
                        $febL = $feb['legal'];
                        $febA = $feb['admin'];
                        $febI = $feb['income'];
                        $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                        $marP = $mar['mprofit'];
                        $marL = $mar['legal'];
                        $marA = $mar['admin'];
                        $marI = $mar['income'];
                        $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                        $aprP = $apr['mprofit'];
                        $aprL = $apr['legal'];
                        $aprA = $apr['admin'];
                        $aprI = $apr['income'];
                        $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                        $mayP = $may['mprofit'];
                        $mayL = $may['legal'];
                        $mayA = $may['admin'];
                        $mayI = $may['income'];
                        $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                        $junP = $jun['mprofit'];
                        $junL = $jun['legal'];
                        $junA = $jun['admin'];
                        $junI = $jun['income'];
                        $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                        $julP = $jul['mprofit'];
                        $julL = $jul['legal'];
                        $julA = $jul['admin'];
                        $julI = $jul['income'];
                        $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                        $augP = $aug['mprofit'];
                        $augL = $aug['legal'];
                        $augA = $aug['admin'];
                        $augI = $aug['income'];
                        $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                        $sepP = $sep['mprofit'];
                        $sepL = $sep['legal'];
                        $sepA = $sep['admin'];
                        $sepI = $sep['income'];
                        $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                        $octP = $oct['mprofit'];
                        $octL = $oct['legal'];
                        $octA = $oct['admin'];
                        $octI = $oct['income'];
                        $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                        $novP = $nov['mprofit'];
                        $novL = $nov['legal'];
                        $novA = $nov['admin'];
                        $novI = $nov['income'];
                        $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                        $decP = $dec['mprofit'];
                        $decL = $dec['legal'];
                        $decA = $dec['admin'];
                        $decI = $dec['income'];

                        $mtotal = ($janI * 13) + ($febI * 12) + ($marI * 11) + ($aprI * 10) + ($mayI * 9) + ($junI * 8) + ($julI * 7) + ($augI * 6) + ($sepI * 5) +
                            ($octI * 4) + ($novI * 3) + ($decI * 2) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepL - $sepA - $octL - $octA - $novL - $novA - $decL - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 2)
                    @php
                        $mtotal = ($janI * 14) + ($febI * 13) + ($marI * 12) + ($aprI * 11) + ($mayI * 10) + ($junI * 9) + ($julI * 8) + ($augI * 7) + ($sepI * 6) +
                            ($octI * 5) + ($novI * 4) + ($decI * 3) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA- $sepA - $octL - $octA - $novL - $novA - $decL - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 3)
                    @php
                        $mtotal = ($janI * 15) + ($febI * 14) + ($marI * 13) + ($aprI * 12) + ($mayI * 11) + ($junI * 10) + ($julI * 9) + ($augI * 8) + ($sepI * 7) +
                            ($octI * 6) + ($novI * 5) + ($decI * 4) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novL - $novA - $decL - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 4)
                    @php
                        $mtotal =  ($janI * 16) + ($febI * 15) + ($marI * 14) + ($aprI * 13) + ($mayI * 12) + ($junI * 11) + ($julI * 10) + ($augI * 9) + ($sepI * 8) +
                            ($octI * 7) + ($novI * 6) + ($decI * 5) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decL - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 5)
                    @php
                        $mtotal =  ($janI * 17) + ($febI * 16) + ($marI * 15) + ($aprI * 14) + ($mayI * 13) + ($junI * 12) + ($julI * 11) + ($augI * 10) + ($sepI * 9) +
                            ($octI * 8) + ($novI * 7) + ($decI * 6)- $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 6)
                    @php
                        $mtotal =  ($janI * 18) + ($febI * 17) + ($marI * 16) + ($aprI * 15) + ($mayI * 14) + ($junI * 13) + ($julI * 12) + ($augI * 11) + ($sepI * 10) +
                            ($octI * 9) + ($novI * 8) + ($decI * 7) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 7)
                    @php
                        $mtotal =  ($janI * 19) + ($febI * 18) + ($marI * 17) + ($aprI * 16) + ($mayI * 15) + ($junI * 14) + ($julI * 13) + ($augI * 12) + ($sepI * 11) +
                            ($octI * 10) + ($novI * 9) + ($decI * 8) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 8)
                    @php
                        $mtotal =  ($janI * 20) + ($febI * 19) + ($marI * 18) + ($aprI * 17) + ($mayI * 16) + ($junI * 15) + ($julI * 14) + ($augI * 13) + ($sepI * 12) +
                            ($octI * 11) + ($novI * 10) + ($decI * 9) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 9)
                    @php
                        $mtotal =  ($janI * 21) + ($febI * 20) + ($marI * 19) + ($aprI * 18) + ($mayI * 17) + ($junI * 16) + ($julI * 15) + ($augI * 14) + ($sepI * 13) +
                            ($octI * 12) + ($novI * 11) + ($decI * 10) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 10)
                    @php
                        $mtotal =  ($janI * 22) + ($febI * 21) + ($marI * 20) + ($aprI * 19) + ($mayI * 18) + ($junI * 17) + ($julI * 16) + ($augI * 15) + ($sepI * 14) +
                            ($octI * 13) + ($novI * 12) + ($decI * 11) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 11)
                    @php
                        $mtotal =  ($febI * 22) + ($marI * 21) + ($aprI * 20) + ($mayI * 19) + ($junI * 18) + ($julI * 17) + ($augI * 16) + ($sepI * 15) +
                            ($octI * 14) + ($novI * 13) + ($decI * 12) - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 12)
                    @php
                        $mtotal =  ($marI * 22) + ($aprI * 21) + ($mayI * 20) + ($junI * 19) + ($julI * 18) + ($augI * 17) + ($sepI * 16) +
                        ($octI * 15) + ($novI * 14) + ($decI * 13) - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @endif
                    @endfor
                    @php
                        $ytotal = ($janI * 10) + ($febI * 11) + ($marI * 12) + ($aprI * 12) + ($mayI * 12) + ($junI * 12) + ($julI * 12) + ($augI * 12) + ($sepI * 12) +
                        ($octI * 12) + ($novI * 12) + ($decI * 12) - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepL - $sepA - $octL - $octA - $novL - $novA - $decL - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA- $sepA - $octL - $octA - $novL - $novA - $decL - $decA - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novL - $novA - $decL - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decL - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $janA - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $febA - $marA - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $ytotal }}
                ],
                fill: true,
            }, {
                label: 'Monthly Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @php
                        $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                        $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                        $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                        $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                        $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                        $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                        $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                        $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                        $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                        $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                        $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                        $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                    @endphp

                    @php
                        $profit1 = ($janI * 13) + ($febI * 12) + ($marI * 11) + ($aprI * 10) + ($mayI * 9) + ($junI * 8) + ($julI * 7) + ($augI * 6) + ($sepI * 5) +
                            ($octI * 4) + ($novI * 3) + ($decI * 2);

                        $profit2 = ($janI * 14) + ($febI * 13) + ($marI * 12) + ($aprI * 11) + ($mayI * 10) + ($junI * 9) + ($julI * 8) + ($augI * 7) + ($sepI * 6) +
                            ($octI * 5) + ($novI * 4) + ($decI * 3);

                        $profit3 = ($janI * 15) + ($febI * 14) + ($marI * 13) + ($aprI * 12) + ($mayI * 11) + ($junI * 10) + ($julI * 9) + ($augI * 8) + ($sepI * 7) +
                            ($octI * 6) + ($novI * 5) + ($decI * 4);

                        $profit4 = ($janI * 16) + ($febI * 15) + ($marI * 14) + ($aprI * 13) + ($mayI * 12) + ($junI * 11) + ($julI * 10) + ($augI * 9) + ($sepI * 8) +
                            ($octI * 7) + ($novI * 6) + ($decI * 5);

                        $profit5 = ($janI * 17) + ($febI * 16) + ($marI * 15) + ($aprI * 14) + ($mayI * 13) + ($junI * 12) + ($julI * 11) + ($augI * 10) + ($sepI * 9) +
                            ($octI * 8) + ($novI * 7) + ($decI * 6);

                        $profit6 = ($janI * 18) + ($febI * 17) + ($marI * 16) + ($aprI * 15) + ($mayI * 14) + ($junI * 13) + ($julI * 12) + ($augI * 11) + ($sepI * 10) +
                            ($octI * 9) + ($novI * 8) + ($decI * 7);

                        $profit7 = ($janI * 19) + ($febI * 18) + ($marI * 17) + ($aprI * 16) + ($mayI * 15) + ($junI * 14) + ($julI * 13) + ($augI * 12) + ($sepI * 11) +
                            ($octI * 10) + ($novI * 9) + ($decI * 8);

                        $profit8 = ($janI * 20) + ($febI * 19) + ($marI * 18) + ($aprI * 17) + ($mayI * 16) + ($junI * 15) + ($julI * 14) + ($augI * 13) + ($sepI * 12) +
                            ($octI * 11) + ($novI * 10) + ($decI * 9);

                        $profit9 = ($janI * 21) + ($febI * 20) + ($marI * 19) + ($aprI * 18) + ($mayI * 17) + ($junI * 16) + ($julI * 15) + ($augI * 14) + ($sepI * 13) +
                            ($octI * 12) + ($novI * 11) + ($decI * 10);

                        $profit10 = ($janI * 22) + ($febI * 21) + ($marI * 20) + ($aprI * 19) + ($mayI * 18) + ($junI * 17) + ($julI * 16) + ($augI * 15) + ($sepI * 14) +
                            ($octI * 13) + ($novI * 12) + ($decI * 11);

                        $profit11 = ($febI * 22) + ($marI * 21) + ($aprI * 20) + ($mayI * 19) + ($junI * 18) + ($julI * 17) + ($augI * 16) + ($sepI * 15) +
                            ($octI * 14) + ($novI * 13) + ($decI * 12);

                        $profit12 = ($marI * 22) + ($aprI * 21) + ($mayI * 20) + ($junI * 19) + ($julI * 18) + ($augI * 17) + ($sepI * 16) +
                            ($octI * 15) + ($novI * 14) + ($decI * 13);

                        $ytotal = ($janI * 10) + ($febI * 11) + ($marI * 12) + ($aprI * 12) + ($mayI * 12) + ($junI * 12) + ($julI * 12) + ($augI * 12) + ($sepI * 12) +
                            ($octI * 12) + ($novI * 12) + ($decI * 12);
                    @endphp
                    {{ $profit1 }},
                    {{ $profit2 }},
                    {{ $profit3 }},
                    {{ $profit4 }},
                    {{ $profit5 }},
                    {{ $profit6 }},
                    {{ $profit7 }},
                    {{ $profit8 }},
                    {{ $profit9 }},
                    {{ $profit10 }},
                    {{ $profit11 }},
                    {{ $profit12 }},
                    {{ $ytotal }},
                ],
            }, {
                label: 'Fees to Date',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($i = 1; $i <= 12; $i++)
                        @if($i == 1)
                            @php
                                $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                                $janP = $jan['mprofit'];
                                $janL = $jan['legal'];
                                $janA = $jan['admin'];
                                $janI = $jan['income'];
                                $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                                $febP = $feb['mprofit'];
                                $febL = $feb['legal'];
                                $febA = $feb['admin'];
                                $febI = $feb['income'];
                                $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                                $marP = $mar['mprofit'];
                                $marL = $mar['legal'];
                                $marA = $mar['admin'];
                                $marI = $mar['income'];
                                $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                                $aprP = $apr['mprofit'];
                                $aprL = $apr['legal'];
                                $aprA = $apr['admin'];
                                $aprI = $apr['income'];
                                $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                                $mayP = $may['mprofit'];
                                $mayL = $may['legal'];
                                $mayA = $may['admin'];
                                $mayI = $may['income'];
                                $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                                $junP = $jun['mprofit'];
                                $junL = $jun['legal'];
                                $junA = $jun['admin'];
                                $junI = $jun['income'];
                                $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                                $julP = $jul['mprofit'];
                                $julL = $jul['legal'];
                                $julA = $jul['admin'];
                                $julI = $jul['income'];
                                $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                                $augP = $aug['mprofit'];
                                $augL = $aug['legal'];
                                $augA = $aug['admin'];
                                $augI = $aug['income'];
                                $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                                $sepP = $sep['mprofit'];
                                $sepL = $sep['legal'];
                                $sepA = $sep['admin'];
                                $sepI = $sep['income'];
                                $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                                $octP = $oct['mprofit'];
                                $octL = $oct['legal'];
                                $octA = $oct['admin'];
                                $octI = $oct['income'];
                                $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                                $novP = $nov['mprofit'];
                                $novL = $nov['legal'];
                                $novA = $nov['admin'];
                                $novI = $nov['income'];
                                $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                                $decP = $dec['mprofit'];
                                $decL = $dec['legal'];
                                $decA = $dec['admin'];
                                $decI = $dec['income'];

                                $mtotal = $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepL + $sepA + $octL + $octA + $novL + $novA + $decL + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 2)
                            @php
                                $mtotal = $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA+ $sepA + $octL + $octA + $novL + $novA + $decL + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 3)
                            @php
                                $mtotal = $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novL + $novA + $decL + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 4)
                            @php
                                $mtotal =  $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decL + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 5)
                            @php
                                $mtotal =  $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 6)
                            @php
                                $mtotal =  $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 7)
                            @php
                                $mtotal =  $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 8)
                            @php
                                $mtotal =  $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 9)
                            @php
                                $mtotal =  $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 10)
                            @php
                                $mtotal =  $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 11)
                            @php
                                $mtotal =  $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                            @elseif($i == 12)
                            @php
                                $mtotal =  $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA;
                            @endphp
                            {{ $mtotal }},
                        @endif
                    @endfor
                    @php
                        $ytotal = $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepL + $sepA + $octL + $octA + $novL + $novA + $decL + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA+ $sepA + $octL + $octA + $novL + $novA + $decL + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novL + $novA + $decL + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decL + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $janA + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $febA + $marA + $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                    @endphp
                        {{ $ytotal }}
                ],
            }]
        };

        var analysis = {
            @php
                $m = date('m');
                $current = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($m - 1);
            @endphp
            datasets: [{
                label: ['Previous Month', 'Current Month'],
                backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                data: [
                    @php
                        $prev = $previous['income'];
                        $now = $current['income'];
                    @endphp
                    {!! $prev !!},
                    {!! $now !!}
                ],
                fill: true,
            }]
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
            var myChart = new Chart(contextAnalysis, {
                type: 'pie',
                data: analysis,
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
        $('#a-report').text("Yearly Perspective");
        $('#t-profit').text("Total Sales");
        $('#a-revenue').text("Monthly Revenue");
        $('#a-fees').text("Fees to Date");
        $('#t-profit-value').text('$' + '{{ number_format($totalProfit['profit'], 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($totalProfit['income'], 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($totalProfit['payables'], 2) }}')
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
                    @for($i = 1; $i <= 12; $i++)
                    @if($i == 1)
                    @php
                        $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                        $janP = $jan['mprofit'];
                        $janL = $jan['legal'];
                        $janA = $jan['admin'];
                        $janI = $jan['income'];
                        $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                        $febP = $feb['mprofit'];
                        $febL = $feb['legal'];
                        $febA = $feb['admin'];
                        $febI = $feb['income'];
                        $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                        $marP = $mar['mprofit'];
                        $marL = $mar['legal'];
                        $marA = $mar['admin'];
                        $marI = $mar['income'];
                        $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                        $aprP = $apr['mprofit'];
                        $aprL = $apr['legal'];
                        $aprA = $apr['admin'];
                        $aprI = $apr['income'];
                        $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                        $mayP = $may['mprofit'];
                        $mayL = $may['legal'];
                        $mayA = $may['admin'];
                        $mayI = $may['income'];
                        $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                        $junP = $jun['mprofit'];
                        $junL = $jun['legal'];
                        $junA = $jun['admin'];
                        $junI = $jun['income'];
                        $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                        $julP = $jul['mprofit'];
                        $julL = $jul['legal'];
                        $julA = $jul['admin'];
                        $julI = $jul['income'];
                        $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                        $augP = $aug['mprofit'];
                        $augL = $aug['legal'];
                        $augA = $aug['admin'];
                        $augI = $aug['income'];
                        $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                        $sepP = $sep['mprofit'];
                        $sepL = $sep['legal'];
                        $sepA = $sep['admin'];
                        $sepI = $sep['income'];
                        $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                        $octP = $oct['mprofit'];
                        $octL = $oct['legal'];
                        $octA = $oct['admin'];
                        $octI = $oct['income'];
                        $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                        $novP = $nov['mprofit'];
                        $novL = $nov['legal'];
                        $novA = $nov['admin'];
                        $novI = $nov['income'];
                        $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                        $decP = $dec['mprofit'];
                        $decL = $dec['legal'];
                        $decA = $dec['admin'];
                        $decI = $dec['income'];

                        $mtotal =  ($aprI * 22) + ($mayI * 21) + ($junI * 20) + ($julI * 19) + ($augI * 18) + ($sepI * 17) +
                        ($octI * 16) + ($novI * 15) + ($decI * 14) - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 2)
                    @php
                        $mtotal =  ($mayI * 22) + ($junI * 21) + ($julI * 20) + ($augI * 19) + ($sepI * 18) +
                        ($octI * 17) + ($novI * 16) + ($decI * 15) - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 3)
                    @php
                        $mtotal =  ($junI * 22) + ($julI * 21) + ($augI * 20) + ($sepI * 19) +
                        ($octI * 18) + ($novI * 17) + ($decI * 16) - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 4)
                    @php
                        $mtotal =  ($julI * 22) + ($augI * 21) + ($sepI * 20) +
                        ($octI * 19) + ($novI * 18) + ($decI * 17) - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 5)
                    @php
                        $mtotal =  ($augI * 22) + ($sepI * 21) +
                        ($octI * 20) + ($novI * 19) + ($decI * 18) - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 6)
                    @php
                        $mtotal =  ($sepI * 22) +
                        ($octI * 21) + ($novI * 20) + ($decI * 19) - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 7)
                    @php
                        $mtotal = ($octI * 22) + ($novI * 21) + ($decI * 20) - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 8)
                    @php
                        $mtotal = ($novI * 22) + ($decI * 21) - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 9)
                    @php
                        $mtotal = ($decI * 22) - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 10)
                    @php
                        $motal = 0;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 11)
                    @php
                        $motal = 0;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 12)
                    @php
                        $motal = 0;
                    @endphp
                    {{ $mtotal }},
                    @endif
                    @endfor
                    @php
                        $ytotal = ($aprI) + ($mayI * 2) + ($junI * 3) + ($julI * 4) + ($augI * 5) + ($sepI * 6) + ($octI * 7) + ($novI * 8) + ($decI * 9)
                        - $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $junA - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $julA - $augA - $sepA - $octA - $novA - $decA
                        - $augA - $sepA - $octA - $novA - $decA
                        - $sepA - $octA - $novA - $decA
                        - $octA - $novA - $decA
                        - $novA - $decA
                        - $decA;
                    @endphp
                    {{ $ytotal }}
                ],
                fill: true,
            }, {
                label: 'Monthly Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @php
                        $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                        $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                        $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                        $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                        $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                        $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                        $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                        $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                        $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                        $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                        $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                        $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                    @endphp

                    @php
                        $profit1 = ($aprI * 22) + ($mayI * 21) + ($junI * 20) + ($julI * 19) + ($augI * 18) + ($sepI * 17) +
                        ($octI * 16) + ($novI * 15) + ($decI * 14);

                        $profit2 = ($mayI * 22) + ($junI * 21) + ($julI * 20) + ($augI * 19) + ($sepI * 18) +
                        ($octI * 17) + ($novI * 16) + ($decI * 15);

                        $profit3 = ($junI * 22) + ($julI * 21) + ($augI * 20) + ($sepI * 19) +
                        ($octI * 18) + ($novI * 17) + ($decI * 16) - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;

                        $profit4 = ($julI * 22) + ($augI * 21) + ($sepI * 20) +
                        ($octI * 19) + ($novI * 18) + ($decI * 17) - $julA - $augA - $sepA - $octA - $novA - $decA;

                        $profit5 = ($augI * 22) + ($sepI * 21) +
                        ($octI * 20) + ($novI * 19) + ($decI * 18) - $augA - $sepA - $octA - $novA - $decA;

                        $profit6 = ($sepI * 22) +
                        ($octI * 21) + ($novI * 20) + ($decI * 19) - $sepA - $octA - $novA - $decA;

                        $profit7 = ($octI * 22) + ($novI * 21) + ($decI * 20) - $octA - $novA - $decA;

                        $profit8 = ($novI * 22) + ($decI * 21) - $novA - $decA;

                        $profit9 = ($decI * 22) - $decA;

                        $profit10 = 0;

                        $profit11 = 0;

                        $profit12 = 0;

                        $ytotal = ($aprI) + ($mayI * 2) + ($junI * 3) + ($julI * 4) + ($augI * 5) + ($sepI * 6) + ($octI * 7) + ($novI * 8) + ($decI * 9);
                    @endphp
                    {{ $profit1 }},
                    {{ $profit2 }},
                    {{ $profit3 }},
                    {{ $profit4 }},
                    {{ $profit5 }},
                    {{ $profit6 }},
                    {{ $profit7 }},
                    {{ $profit8 }},
                    {{ $profit9 }},
                    {{ $profit10 }},
                    {{ $profit11 }},
                    {{ $profit12 }},
                    {{ $ytotal }},
                ],
            }, {
                label: 'Fees to Date',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($i = 1; $i <= 12; $i++)
                    @if($i == 1)
                    @php
                        $jan = \App\Http\Controllers\CashRegisterController::monthlyGross(1);
                        $janP = $jan['mprofit'];
                        $janL = $jan['legal'];
                        $janA = $jan['admin'];
                        $janI = $jan['income'];
                        $feb = \App\Http\Controllers\CashRegisterController::monthlyGross(2);
                        $febP = $feb['mprofit'];
                        $febL = $feb['legal'];
                        $febA = $feb['admin'];
                        $febI = $feb['income'];
                        $mar = \App\Http\Controllers\CashRegisterController::monthlyGross(3);
                        $marP = $mar['mprofit'];
                        $marL = $mar['legal'];
                        $marA = $mar['admin'];
                        $marI = $mar['income'];
                        $apr = \App\Http\Controllers\CashRegisterController::monthlyGross(4);
                        $aprP = $apr['mprofit'];
                        $aprL = $apr['legal'];
                        $aprA = $apr['admin'];
                        $aprI = $apr['income'];
                        $may = \App\Http\Controllers\CashRegisterController::monthlyGross(5);
                        $mayP = $may['mprofit'];
                        $mayL = $may['legal'];
                        $mayA = $may['admin'];
                        $mayI = $may['income'];
                        $jun = \App\Http\Controllers\CashRegisterController::monthlyGross(6);
                        $junP = $jun['mprofit'];
                        $junL = $jun['legal'];
                        $junA = $jun['admin'];
                        $junI = $jun['income'];
                        $jul = \App\Http\Controllers\CashRegisterController::monthlyGross(7);
                        $julP = $jul['mprofit'];
                        $julL = $jul['legal'];
                        $julA = $jul['admin'];
                        $julI = $jul['income'];
                        $aug = \App\Http\Controllers\CashRegisterController::monthlyGross(8);
                        $augP = $aug['mprofit'];
                        $augL = $aug['legal'];
                        $augA = $aug['admin'];
                        $augI = $aug['income'];
                        $sep = \App\Http\Controllers\CashRegisterController::monthlyGross(9);
                        $sepP = $sep['mprofit'];
                        $sepL = $sep['legal'];
                        $sepA = $sep['admin'];
                        $sepI = $sep['income'];
                        $oct = \App\Http\Controllers\CashRegisterController::monthlyGross(10);
                        $octP = $oct['mprofit'];
                        $octL = $oct['legal'];
                        $octA = $oct['admin'];
                        $octI = $oct['income'];
                        $nov = \App\Http\Controllers\CashRegisterController::monthlyGross(11);
                        $novP = $nov['mprofit'];
                        $novL = $nov['legal'];
                        $novA = $nov['admin'];
                        $novI = $nov['income'];
                        $dec = \App\Http\Controllers\CashRegisterController::monthlyGross(12);
                        $decP = $dec['mprofit'];
                        $decL = $dec['legal'];
                        $decA = $dec['admin'];
                        $decI = $dec['income'];

                        $mtotal = $aprA - $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 2)
                    @php
                        $mtotal = $mayA - $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 3)
                    @php
                        $mtotal = $junA - $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 4)
                    @php
                        $mtotal =  $julA - $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 5)
                    @php
                        $mtotal =  $augA - $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 6)
                    @php
                        $mtotal =  $sepA - $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 7)
                    @php
                        $mtotal =  $octA - $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 8)
                    @php
                        $mtotal =  $novA - $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 9)
                    @php
                        $mtotal =  $decA;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 10)
                    @php
                        $mtotal =  0;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 11)
                    @php
                        $mtotal =  0;
                    @endphp
                    {{ $mtotal }},
                    @elseif($i == 12)
                    @php
                        $mtotal =  0;
                    @endphp
                    {{ $mtotal }},
                    @endif
                    @endfor
                    @php
                        $ytotal = $aprA + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $mayA + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $junA + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $julA + $augA + $sepA + $octA + $novA + $decA
                        + $augA + $sepA + $octA + $novA + $decA
                        + $sepA + $octA + $novA + $decA
                        + $octA + $novA + $decA
                        + $novA + $decA
                        + $decA;
                    @endphp
                    {{ $ytotal }}
                ],
            }]
        };

        var analysis = {
            @php
                $m = date('m');
                $current = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($m - 1);
            @endphp
            datasets: [{
                label: ['Previous Month', 'Current Month'],
                backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                data: [
                    @php
                        $prev = $previous['income'];
                        $now = $current['income'];
                    @endphp
                    {!! $prev !!},
                    {!! $now !!}
                ],
                fill: true,
            }]
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
            var myChart = new Chart(contextAnalysis, {
                type: 'pie',
                data: analysis,
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
            @php
                $m = date('m');
                $monthly = \App\Http\Controllers\CashRegisterController::monthlyGross($m);

                switch($month){
                    case "1":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "2":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "3":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "4":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "5":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "6":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "7":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "8":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "9":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "10":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "11":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    case "12":
                        $d = date('m');
                        if($month < $d){
                            $income = 0;
                            $fees = 0;
                        }else if($d == $month){
                            $income = $monthly['income'];
                            $fees = $monthly['monthlyPayables'];
                            $profit = $income - $fees;
                        }else if($month > $d){
                            $num_of_months = $month - $d;
                            $income = $monthly['income'] * ($num_of_months+1);
                            if($num_of_months >= 1 && $num_of_months < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($num_of_months > 4){
                                $fees = ($monthly['admin']);
                            }
                        }
                    break;
                    default:
                }
            @endphp
        $('#t-profit-value').text('$' + '{{ number_format(!isset($profit) ? 0 : $profit, 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($income, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($fees, 2) }}')
        $('#ytd').text('{{number_format($ytd, 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        $('#ytd-label').text('Growth (MTD)')

        var monthlyData = {
            labels: months_22,
            datasets: [{
                label: '22-Months Profit',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['profit'];
                        $fifth = $first;
                    @endphp
                    {!! $first !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth += $grossIncome['income'] - ($grossIncome['legal'] + $grossIncome['admin']);
                        $twentytwoth = $fifth;
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth += $grossIncome['income'] - ($grossIncome['admin']);
                    @endphp
                    {!! $twentytwoth !!},
                    @endfor
                ],
                fill: true,
            }, {
                label: '22-Months Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['profit'];
                        $fifth = $first;
                    @endphp
                    {!! $first !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth = $grossIncome['income'] - ($grossIncome['legal'] + $grossIncome['admin']);
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth = $grossIncome['income'] - ($grossIncome['admin']);
                    @endphp
                    {!! $twentytwoth !!},
                    @endfor
                ],
            }, {
                label: '22-Months Fees',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['monthlyPayables'];
                    @endphp
                    {!! $first !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth = ($grossIncome['legal'] + $grossIncome['admin']);
                    @endphp
                    {!! $fifth !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth = ($grossIncome['admin']);
                    @endphp
                    {!! $twentytwoth !!},
                    @endfor
                ],
            }]
        };
        @elseif($year == '2020')
            @php
                $m = date('m');
                $monthly = \App\Http\Controllers\CashRegisterController::monthlyGross($m);

                switch($month){
                    case "1":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "2":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "3":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "4":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "5":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "6":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "7":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "8":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "9":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "10":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "11":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    case "12":
                    $d = 12 - date('m');
                    $proj = $d + $month;
                    $income = $monthly['income'] * $proj;

                    if($proj >= 1 && $proj < 5){
                        $fees = ($monthly['admin'] + $monthly['legal']);
                    }else if($proj > 4){
                        $fees = ($monthly['admin']);
                    }
                    $profit = $income - $fees;
                    break;
                    default:
                }
            @endphp
        $('#t-profit-value').text('$' + '{{ number_format('0', 2) }}')
        $('#a-revenue-value').text('$' + '{{ number_format($income, 2) }}')
        $('#a-fees-value').text('$' + '{{ number_format($fees, 2) }}')
        $('#ytd').text('{{number_format('0', 2)}}%');
        $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
        $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
        $('#ytd-label').text('Growth (MTD)')

        var monthlyData = {
            labels: months_22,
            datasets: [{
                label: '22-Months Profit',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['profit'];
                        $fifth = $first;
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
          s              $fifth += $grossIncome['income'] - ($grossIncome['legal'] + $grossIncome['admin']);
                        $twentytwoth = $fifth;
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth += $grossIncome['income'] - ($grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                ],
                fill: true,
            }, {
                label: '22-Months Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['profit'];
                        $fifth = $first;
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth = $grossIncome['income'] - ($grossIncome['legal'] + $grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth = $grossIncome['income'] - ($grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                ],
            }, {
                label: '22-Months Fees',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['monthlyPayables'];
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth = ($grossIncome['legal'] + $grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth = ($grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                ],
            }]
        };
        @elseif($year == '2021')
                @php
                    $m = date('m');
                    $monthly = \App\Http\Controllers\CashRegisterController::monthlyGross($m);

                        switch($month){
                        case "1":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "2":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "3":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "4":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "5":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "6":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "7":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "8":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "9":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "10":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "11":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        case "12":
                            $d = 12 - date('m');
                            $proj = $d + $month + 12;

                            if($proj >= 1 && $proj < 5){
                                $fees = ($monthly['admin'] + $monthly['legal']);
                            }else if($proj > 4 && $proj < 23){
                                $income = $monthly['income'] * $proj;
                                $fees = ($monthly['admin']);
                            }else if($proj > 22){
                                $income = 0;
                                $fees = 0;
                            }
                            $profit = $income - $fees;
                            break;
                        default:
                    }
                @endphp
            $('#t-profit-value').text('$' + '{{ number_format('0', 2) }}')
            $('#a-revenue-value').text('$' + '{{ number_format($income, 2) }}')
            $('#a-fees-value').text('$' + '{{ number_format($fees, 2) }}')
            $('#ytd').text('{{number_format('0', 2)}}%');
            $('.ytd').attr('aria-valuenow', '{{number_format($ytd, 2)}}');
            $('.ytd').css('width', '{{number_format($ytd, 2)}}%');
            $('#ytd-label').text('Growth (MTD)')
        var monthlyData = {
            labels: months_22,
            datasets: [{
                label: '22-Months Profit',
                backgroundColor: 'rgba(0, 255, 0, 0.3)',
                borderColor: 'rgba(0, 255, 0, 0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['profit'];
                        $fifth = $first;
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth += $grossIncome['income'] - ($grossIncome['legal'] + $grossIncome['admin']);
                        $twentytwoth = $fifth;
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth += $grossIncome['income'] - ($grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                ],
                fill: true,
            }, {
                label: '22-Months Revenue',
                fill: true,
                backgroundColor: 'rgba(0, 0, 255, 0.3)',
                borderColor: 'rgba(0, 0, 255, 0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['profit'];
                        $fifth = $first;
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth = $grossIncome['income'] - ($grossIncome['legal'] + $grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth = $grossIncome['income'] - ($grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                ],
            }, {
                label: '22-Months Fees',
                fill: true,
                backgroundColor: 'rgba(255,255,0,0.3)',
                borderColor: 'rgba(255,255,0,0.2)',
                data: [
                    @for($j = 1; $j <=1; $j++)
                    @php
                        $first = $grossIncome['monthlyPayables'];
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($k = 2; $k <=5; $k++)
                    @php
                        $fifth = ($grossIncome['legal'] + $grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                    @for($l = 6; $l <=22; $l++)
                    @php
                        $twentytwoth = ($grossIncome['admin']);
                    @endphp
                    {!! 0 !!},
                    @endfor
                ],
            }]
        };
        @endif

        var analysis = {
            @php
                $m = date('m');
                $current = \App\Http\Controllers\CashRegisterController::monthlyGross($m);
                $previous = \App\Http\Controllers\CashRegisterController::monthlyGross($m - 1);
            @endphp
            datasets: [{
                label: ['Previous Month', 'Current Month'],
                backgroundColor: ['rgba(255, 255, 0, 0.3)', 'rgba(0, 0, 255, 0.3)'],
                data: [
                    @php
                        $prev = $previous['income'];
                        $now = $current['income'];
                    @endphp
                    {!! $prev !!},
                    {!! $now !!}
                ],
                fill: true,
            }]
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
                data: monthlyData,
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
            var myChart = new Chart(contextAnalysis, {
                type: 'pie',
                data: analysis,
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
    </script>
@endsection

