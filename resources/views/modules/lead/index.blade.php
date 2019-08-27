@extends('layouts.lucid')
@section('breadcrumbs')
{{ Breadcrumbs::render('lead.index', @$department->name) }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/nestable/jquery-nestable.css') }}">
<link rel="stylesheet" href="{{ asset('/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/css/select2.css') }}">
<style type="text/css">
    .dd-handle {
        cursor: move;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <h2>Leads Summary</h2>
                        </div>
                        @foreach($lead_statuses as $lead_status)
                        @php
                            $status = @json_decode($lead_status->value);
                        @endphp
                        <div class="col-md-2 col-xs-6 border-right">
                            <h3 class="bold">{{ $lead_status->leads->count() }}</h3>
                            <span style="color: {{ $status->color }};">{{ @$status->name }}</span>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <p><strong>Filter by</strong></p>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="status_id" class="control-label">Status</label>
                                <select id="status_id" class="form-control selectclass2" multiple>
                                    @foreach($lead_statuses as $lead_status)
                                    @php
                                        $status = @json_decode($lead_status->value);
                                    @endphp
                                    <option value="{{ $lead_status->id }}">{{@$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="source_id" class="control-label">Source</label>
                                <select id="source_id" class="form-control selectclass2" multiple>
                                    @foreach($lead_sources as $lead_source)
                                    @php
                                        $source = @json_decode($lead_source->value);
                                    @endphp
                                    <option value="{{ $lead_source->id }}">{{@$source->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="type_id" class="control-label">Type</label>
                                <select id="type_id" class="form-control selectclass2" multiple>
                                    @foreach($lead_types as $lead_type)
                                    @php
                                        $type = @json_decode($lead_type->value);
                                    @endphp
                                    <option value="{{ $lead_type->id }}">{{@$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6"></div>

                    </div>
                    <hr>
                    <h2>Leads - {{ @$department->name }} </h2>
{{--                     @permission('add-lead')
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#add-modal">Add New Lead</button>
                    @endpermission --}}
                    {{-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#lead-fields-modal">Lead Column</button> --}}
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover js-basic-example dataTable table-custom" id="datatable">
                                <thead>
                                    <tr>
                                        @foreach ($fields as $field)
                                        <th>{{ $field }}</th>
                                        @endforeach
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Source</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @include('lead::includes._modal_lead_fields') --}}
@permission('edit-lead')
@include('lead::includes._modal_edit')
@endpermission
@permission('add-lead')
@include('lead::includes._modal_add')
@endpermission
@endsection
@section('scripts')
<script src="{{ asset('vendor/formbuilder/js/sweetalert.min.js') }}" defer></script>
<script src="{{ asset('/lucid/light/assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/nestable/jquery.nestable.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="{{ asset('/js/select2.js') }}"></script>
<script>
    var placeholder = "Select Filter";
    $(".selectclass2").select2( {
        placeholder: placeholder,
    });

    //$(function() {
      //  var oldList, newList, item;
        //$('.sortable').sortable({
          //  start: function(event, ui) {
            //    item = ui.item;
             //   newList = oldList = ui.item.parent().parent();
            //},
            //change: function(event, ui) {
              //  if(ui.sender) newList = ui.placeholder.parent().parent();
            //},
            //connectWith: ".sortable"
        //}).disableSelection();
   // });

    var update_route = '{{ route('lead.index') }}';
    $(document).ready(function(){
        var dataTable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
               url: update_route,
               data: function(data) {
                  var source_id = $('#source_id').val();
                  var status_id = $('#status_id').val();
                  var type_id = $('#type_id').val();
                  var department_id = '{{@$_GET['department_id']}}';

                  data.source_id = source_id;
                  data.status_id = status_id;
                  data.type_id = type_id;
                  data.department_id = department_id;
               }
            },
            columns : [
                {data: 'name'},
                {data: 'company'},
                {data: 'email_address'},
                {data: 'phone'},
                {data: 'status'},
                {data: 'type'},
                {data: 'source'},
                // {data: 'department'},
                // {data: 'position'},
                // {data: 'address'},
                // {data: 'city'},
                // {data: 'state'},
                // {data: 'country'},
                // {data: 'zip_code'},
                // {data: 'title'},
                // {data: 'description'},
                // {data: 'website'},
                {data: 'action', orderable: false, searchable: false}
            ],
            pageLength: 30,
            lengthMenu: [
                [5, 10, 20, 30, 50, 100],
                [5, 10, 20, 30, 50, 100],
            ],
            autoWidth: !1,
            "initComplete": function() {

                $('.lead-status').change(function () {
                    var lead_id = $(this).data('id');
                    var status_id = $(this).val();

                    var update_lead_route = '{{ route('lead.update', ':id') }}';
                    update_lead_route = update_lead_route.replace(':id', lead_id);

                    $.ajax({
                        type: 'PATCH',
                        url: update_lead_route,
                        data: {
                            'status_id': status_id,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        },
                        jsonp: false,
                        success: function (data) {
                            swal({
                                title: 'Success',
                                text: 'Lead status has been updated',
                                icon: 'success',
                            })
                        }
                    });
                });

                $('.lead-type').change(function () {
                    var lead_id = $(this).data('id');
                    var type_id = $(this).val();

                    var update_lead_route = '{{ route('lead.update', ':id') }}';
                    update_lead_route = update_lead_route.replace(':id', lead_id);

                    $.ajax({
                        type: 'PATCH',
                        url: update_lead_route,
                        data: {
                            'type_id': type_id,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        },
                        jsonp: false,
                        success: function (data) {
                            swal({
                                title: 'Success',
                                text: 'Lead type has been updated',
                                icon: 'success',
                            })
                        }
                    });
                });
            }
        });

        $('#type_id').change(function(){
            dataTable.draw();
        });

        $('#status_id').change(function(){
            dataTable.draw();
        });

        $('#status_id').change(function(){
            dataTable.draw();
        });
    });

    // $(document).on('click', '[id=btn-edit]', function(){
    //     var id = $(this).data('id');
    //     var show_route = '{{ route('lead.show', ':id') }}';
    //     var update_route = '{{ route('lead.update', ':id') }}';
    //     show_route = show_route.replace(':id', id);
    //     update_route = update_route.replace(':id', id);
    //     if (id) {
    //         $.ajax({
    //             method: 'get',
    //             url: show_route,
    //             jsonp: false,
    //             success: function(result) {
    //                 $('[id=id]').val(result.id);
    //                 $('[id=name]').val(result.name);
    //                 $("[id=update-form]").attr("action", update_route);
    //                 $('[id=edit-modal]').modal();
    //             }
    //         });
    //     }
    // });
</script>
@endsection
