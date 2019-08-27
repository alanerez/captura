@extends('layouts.lucid')
@section('breadcrumbs')
{{ Breadcrumbs::render('dashboard') }}
@endsection
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
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6">
            <div class="card overflowhidden">
                <div class="body text-center">
                    <div class="p-15">
                        <h3>{{ $lead_count }}</h3>
                        <span>New Leads</span>
                    </div>
                </div>
                <div class="progress progress-xs progress-transparent custom-color-blue m-b-0">
                    <div class="progress-bar" data-transitiongoal="100"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflowhidden">
                <div class="body text-center">
                    <div class="p-15">
                        <h3>{{ $lead_source_count }}</h3>
                        <span>New Sources</span>
                    </div>
                </div>
                <div class="progress progress-xs progress-transparent custom-color-purple m-b-0">
                    <div class="progress-bar" data-transitiongoal="100"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflowhidden">
                <div class="body text-center">
                    <div class="p-15">
                        <h3>0</h3>
                        <span>New Tickets</span>
                    </div>
                </div>
                <div class="progress progress-xs progress-transparent custom-color-yellow m-b-0">
                    <div class="progress-bar" data-transitiongoal="100"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card overflowhidden">
                <div class="body text-center">
                    <div class="p-15">
                        <h3>0</h3>
                        <span>Ticket Replies</span>
                    </div>
                </div>
                <div class="progress progress-xs progress-transparent custom-color-green m-b-0">
                    <div class="progress-bar" data-transitiongoal="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>Lead Report</h2>
                    <ul class="header-dropdown">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another Action</a></li>
                                <li><a href="javascript:void(0);">Something else</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div id="m_area_chart" class="m-b-20" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('/lucid/light/assets/bundles/fullcalendarscripts.bundle.js') }}"></script><!--/ calender javascripts -->
<script src="{{ asset('/lucid/assets/vendor/fullcalendar/fullcalendar.js') }}"></script><!--/ calender javascripts -->

<script src="{{ asset('/lucid/light/assets/bundles/morrisscripts.bundle.js') }}"></script>
<script type="text/javascript">

    $('.progress .progress-bar').progressbar({
        display_text: 'none'
    });

    var leads = @json($leads);

    $(function() {

     Morris.Area({
            element: 'm_area_chart',
            data: [{
                    period: '2011',
                    Facebook: 22,
                    Twitter: 5,
                    Instagram: 55
                },{
                    period: '2012',
                    Facebook: 33,
                    Twitter: 11,
                    Instagram: 155
                },{
                    period: '2013',
                    Facebook: 17,
                    Twitter: 23,
                    Instagram: 55
                },{
                    period: '2014',
                    Facebook: 55,
                    Twitter: 17,
                    Instagram: 55
                }, {
                    period: '2015',
                    Facebook: 78,
                    Twitter: 98,
                    Instagram: 140
                }, {
                    period: '2016',
                    Facebook: 59,
                    Twitter: 78,
                    Instagram: 85
                },{
                    period: '2017',
                    Facebook: 170,
                    Twitter: 156,
                    Instagram: 120
                }
            ],
            xkey: 'period',
            ykeys: ['Facebook', 'Twitter', 'Instagram'],
            labels: ['Facebook', 'Twitter', 'Instagram'],
            pointSize: 2,
            fillOpacity: 0,
            pointStrokeColors: ['#0e9be2', '#ab7df6', '#7cac25'],
            behaveLikeLine: true,
            gridLineColor: '#f6f6f6',
            lineWidth: 1,
            hideHover: 'auto',
            lineColors: ['#0e9be2', '#ab7df6', '#7cac25'],
            resize: true

        });

    });

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultDate: '2019-06-10',
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        eventLimit: true, // allow "more" link when too many events
        events: leads
    });

</script>
@endsection
