
@extends('layouts.lucid')
@section('breadcrumbs')
{{ Breadcrumbs::render('reviews.index') }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('/lucid/light/assets/css/inbox.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/summernote/dist/summernote.css') }}">
<style type="text/css">
.panel-body {
    padding: 20px;
}
.panel {
    padding: 10px;
    margin: 5px;
    background: #EEE;
}
pre{
    white-space: pre-wrap;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div id="domMessage" style="display:none;">
        <p>We are processing your request. <br> Please be patient.</p>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="mobile-left">
                    <a class="btn btn-primary toggle-email-nav collapsed" data-toggle="collapse" href="#email-nav" role="button" aria-expanded="false" aria-controls="email-nav">
                        <span class="btn-label">
                            <i class="la la-bars"></i>
                        </span>
                        Menu
                    </a>
                </div>
                <div class="mail-inbox">
                    <div class="mail-left collapse" id="email-nav">
                        <div class="mail-side">

                            <ul class="nav">
{{--<li class="{{ !isset($_GET['department_id']) ? 'active' : '' }}"><a href="{{ route('reviews.index') }}"><i class="fa fa-ticket"></i>All Reviews<span class="badge badge-primary float-right">0</span></a></li>--}}



                                <div class="">
                                    <h3>Departments</h3>
                                </div>
                                @foreach($departments as $department)
                                    <li class="{{ @$_GET['department_id'] == $department->id ? 'active' : '' }}">
                                        <a href="{{ route('reviews.index', ['department_id' => $department->id])}}">
                                            <i class="fa fa-building-o"></i>
                                            {{ $department->name }}<span class="badge badge-primary float-right">0</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>


                        </div>
                    </div>
                    <div class="mail-right">
                        <div id="message-list">
                            <div class="header d-flex align-center">
                                <h2>Reviews</h2>
                                <form class="ml-auto">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search Reviews" aria-label="Search Reviews" aria-describedby="search-mail">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="search-mail"><i class="icon-magnifier"></i></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="mail-action clearfix">
                                <div class="pull-left">
                                    @if(isset($_GET['department_id']))
                                    <div class="btn-group">
                                        <button id="refresh_sync" class="btn btn-outline-secondary btn-sm"><i class="fa fa-refresh"></i></button>
                                    </div>
                                    @endif
                                    <div class="btn-group">
                                       

                                       


                                    </div>
                                </div>
                                <div class="pull-right ml-auto">
                                    <div class="pagination-email d-flex">
                                        
                                            

                                       
                                    </div>
                                </div>
                            </div>
                            <div class="mail-list">
                                <ul class="list-unstyled">
                                    @php if(!empty($reviews)){ @endphp
                                    @forelse($reviews as $review)
                                    <li class="clearfix" {{-- style="background-color: rgba(242,245,245,0.8);" --}}>
                                        <div class="mail-detail-right">
                                            
                                            <h6 class="sub" style="font-size: .8rem;">
                                            <a href="#review{{$review->id}}" class="mail-detail-expand" data-department="" data-messageid="" data-value="" data-id="" data-date="">
                                                {{ $review->name }}
                                            </a>
                                            

                                            <p class="dep"><span class="m-r-10"  style=" color: black;"></span><span>{{ $review->review_text }}</span></p>
                                            <span class="time">{{ date('M d, Y g:i A',strtotime($review->created_at)) }}</span>

                                        </div>
                                        <div class="hover-action">
                                            <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert" title="Delete">
                                            <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                    </li>
                                    @empty
                                        <li class="clearfix">
                                            <div class="mail-detail-right">
                                                <h4>Nothing has arrived yet</h4>
                                            </div>
                                        </li>
                                    @endforelse

                                    @php } @endphp
                                </ul>
                            </div>
                        </div>

                        <div class="mail-detail-full" id="mail-detail-open" style="display: none; height: auto;">
                            <div class="mail-action clearfix">
                                <div class="pull-left">
                                    <h4 id="rep-subject"></h4>
                                </div>
                                <div class="pull-right ml-auto">
                                    <a href="javascript:void(0);" class="mail-back btn btn-outline-secondary btn-sm"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div class="detail-header">
                                <div class="media">
                                    <div class="float-left">
                                        <div class="m-r-20"><img src="{{ asset('img/default.png') }}" alt=""></div>
                                    </div>
                                    <div class="media-body">
                                        <p class="mb-0">
                                            <strong class="text-muted m-r-5">From:</strong>
                                            <a class="text-default" href="javascript:void(0);" id="rep-from"></a>
                                            <span class="text-muted text-sm float-right" id="rep-date"></span>
                                        </p>
                                        <p class="mb-0">
                                            <strong class="text-muted m-r-5">To:</strong>
                                            <a class="text-default" href="javascript:void(0);" id="rep-to"></a>
                                        </p>
                        {{--                 <p class="mb-0">
                                            <strong class="text-muted m-r-5">Cc:</strong>
                                            <a class="text-default" href="javascript:void(0);" id="rep-cc"></a>
                                        </p>
                                         <p class="mb-0">
                                            <strong class="text-muted m-r-5">Bcc:</strong>
                                            <a class="text-default" href="javascript:void(0);" id="rep-bcc"></a>
                                        </p> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="mail-cnt">
                                <div class="panel-group" id="re-html-body">
                                </div>
                                <hr>
                                <div id="reply-button-div">
                                    <strong>Click here to</strong>
                                    <a href="#" id="reply-button">Reply</a>
                                </div>
                            </div>

                            <div class="container mb-5" id="mail-form" style="display: none;">
                                <div class="shadow-lg p-3 mb-5 bg-white rounded">
                                <form id="emailing" action="{{ route('email.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" class="form-control" name="subject" readonly="" id="rep-subject-to">
                                    <input type="hidden" class="form-control" name="message_id" readonly="" id="rep-message-id">
                                    <input type="hidden" class="form-control" name="department_id" readonly="" id="rep-department-id">
                                    <div class="form-group">
                                        <label>To:</label>
                                        <input type="text" class="form-control" name="to" placeholder="To" readonly="" id="rep-input-to">
                                    </div>
                                    <hr>
                                    <textarea class="summernote" id="summernote" name="content"></textarea>
                                </form>

                                <div class="m-t-30">
                                    <button type="submit" form="emailing" class="btn btn-success">Send Message</button>
                                    <a href="#" class="btn btn-outline-secondary" id="cancel-form">Cancel</a>
                                </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('/lucid/light/assets/js/pages/ui/dialogs.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/summernote/dist/summernote.js') }}"></script>
<script src="{{ asset('/js/blockUI.js') }}"></script>
@if(isset($_GET['department_id']))
<script type="text/javascript">

    $(document).ready(function() {
      $('#summernote').summernote();
    });

    $(document).ajaxStop($.unblockUI);

    $(document).ready(function() {

        var sync_route = '{{ route('email.update', $_GET['department_id']) }}';

        $('#refresh_sync').click(function() {
            $.blockUI({ message: $('#domMessage') });

            $.ajax({
                method: 'patch',
                data: {"_token": $('meta[name="csrf-token"]').attr('content')},
                url: sync_route,
                jsonp: false,
                success: function() {
                    window.location.reload();
                }
            });

        });
    });

</script>
@endif
<script>
    $(document).ready(function(){
        $(".mail-detail-expand").click(function(){
            var value = $(this).data('value');

            var date = $(this).data('date');

            var messageid = $(this).data('messageid');

            var departmentid = $(this).data('department');

            var from_data = JSON.parse(value.from);
            var to_data = JSON.parse(value.to);
            var cc_data = JSON.parse(value.cc);
            var bcc_data = JSON.parse(value.bcc);

            var from = [];
            Object.keys(from_data).forEach(function(key) {
              var val = from_data[key]["mail"];
              from.push(val);
            });

            var to = [];
            Object.keys(to_data).forEach(function(key) {
              var val = to_data[key]["mail"];
              to.push(val);
            });

            var cc = [];
            Object.keys(cc_data).forEach(function(key) {
              var val = cc_data[key]["mail"];
              cc.push(val);
            });

            var bcc = [];
            Object.keys(bcc_data).forEach(function(key) {
              var val = bcc_data[key]["mail"];
              bcc.push(val);
            });

            $('#rep-subject').text(value.subject);
            $('#rep-from').text(from);
            $('#rep-to').text(to);
            $('#rep-cc').text(cc);
            $('#rep-bcc').text(bcc);

            $('#rep-input-to').val(from);

            $('#rep-message-id').val(messageid);

            $('#rep-department-id').val(departmentid);

            $('#rep-subject-to').val(value.subject);


            var body = '';

            var jsVarDate = new Date(value.date).toDateString();

            var attachments = JSON.parse(value.attachments);

            body += '<div class="panel panel-default">'+
                            '<div class="panel-heading">'+
                                '<h4 class="panel-title">'+
                                    '<a data-toggle="collapse" data-parent="#re-html-body" href="#'+value.id+'">';
                                        if(!JSON.parse(value.sender)[0].personal) {
                                            var sender = JSON.parse(value.sender)[0].mail;
                                        } else {
                                            var sender = JSON.parse(value.sender)[0].personal;
                                        }
                                        body += sender;
                                        body += '<br>'+
                                        '<span class="time">'+jsVarDate+'</span>'+
                                    '</a>'+
                                '</h4>'+
                            '</div>'+
                            '<div id="'+value.id+'" class="panel-collapse collapse in">'+
                                '<div class="panel-body">'+
                                    '<div class="file_manager">'+
                                        '<div class="row clearfix">';

                                            $.each(attachments, function(attachment_key, attachment) {

                                                var show_route = '{{ route('document.index', ['link' => 'xxx']) }}';
                                                show_route = show_route.replace('xxx', attachment.file_path);

                                                body += '<div class="col-sm-3">'+
                                                            '<div class="card">'+
                                                                '<div class="file">'+
                                                                    '<a href="'+show_route+'">'+
                                                                        '<div class="icon">'+
                                                                            '<i class="fa fa-file text-info"></i>'+
                                                                        '</div>'+
                                                                        '<div class="file-name">'+
                                                                            '<p class="m-b-5 text-muted">'+attachment.name+'</p>'+
                                                                            '<small>Size: '+attachment.size+' <span class="date text-muted">'+jsVarDate+'</span></small>'+
                                                                        '</div>'+
                                                                    '</a>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>';
                                            });


                                body += '</div>'+
                                    '</div>';

                                    if(value.html_body == null) {
                                        value.html_body = '<pre>'+value.text_body+'</pre>';
                                    }

                                    body += value.html_body;

                                body += '</div>'+
                            '</div>'+
                        '</div>';

            $.each(value.childs, function(child_key, child) {

                var jsVar = new Date(child.date).toDateString();

                var attachments = JSON.parse(child.attachments);

                body += '<div class="panel panel-default">'+
                            '<div class="panel-heading">'+
                                '<h4 class="panel-title">'+
                                    '<a data-toggle="collapse" data-parent="#re-html-body" href="#'+child.id+'">';
                                        if(!JSON.parse(child.sender)[0].personal) {
                                            var sender = JSON.parse(child.sender)[0].mail;
                                        } else {
                                            var sender = JSON.parse(child.sender)[0].personal;
                                        }
                                        body += sender;
                                        body += '<br>'+
                                        '<span class="time">'+jsVar+'</span>'+
                                    '</a>'+
                                '</h4>'+
                            '</div>'+
                            '<div id="'+child.id+'" class="panel-collapse collapse in">'+
                                '<div class="panel-body">'+
                                    '<div class="file_manager">'+
                                        '<div class="row clearfix">';

                                            $.each(attachments, function(attachment_key, attachment) {

                                                var show_route = '{{ route('document.index', ['link' => 'xxx']) }}';
                                                show_route = show_route.replace('xxx', attachment.file_path);

                                                body += '<div class="col-sm-3">'+
                                                            '<div class="card">'+
                                                                '<div class="file">'+
                                                                    '<a href="'+show_route+'">'+
                                                                        '<div class="icon">'+
                                                                            '<i class="fa fa-file text-info"></i>'+
                                                                        '</div>'+
                                                                        '<div class="file-name">'+
                                                                            '<p class="m-b-5 text-muted">'+attachment.name+'</p>'+
                                                                            '<small>Size: '+attachment.size+' <span class="date text-muted">'+jsVar+'</span></small>'+
                                                                        '</div>'+
                                                                    '</a>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>';
                                            });


                                   body += '</div>'+
                                    '</div>';

                                    if(child.html_body == null) {
                                        child.html_body = '<pre>'+child.text_body+'</pre>';
                                    }

                                    body += child.html_body;

                                body += '</div>'+
                            '</div>'+
                        '</div>';

            });

            $('#re-html-body').html(body);

            $('#rep-date').text(date);

            $("#mail-detail-open").toggle();
            $("#message-list").toggle();
        });
        $(".mail-back").click(function(){
            $("#mail-detail-open").toggle();
            $("#message-list").toggle();
        });


        $("#reply-button").click(function(){
            $("#reply-button-div").toggle();
            $("#mail-form").toggle();
        });

        $("#cancel-form").click(function(){
            $("#reply-button-div").toggle();
            $("#mail-form").toggle();
        });

    });
</script>
@endsection
