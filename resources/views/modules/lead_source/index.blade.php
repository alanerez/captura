@extends('layouts.lucid')
@section('breadcrumbs')
{{ Breadcrumbs::render('lead-source.index') }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Lead Source</h2>
                    <hr>
                    @permission('add-lead-source')
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#add-modal">Add New Lead Source</button>
                    @endpermission
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" id="datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
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
@permission('edit-lead-source')
@include('lead_source::includes._modal_edit')
@endpermission
@permission('add-lead-source')
@include('lead_source::includes._modal_add')
@endpermission
@endsection
@section('scripts')
<script src="{{ asset('/lucid/light/assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script>
    jQuery("#datatable").dataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('lead-source.index') }}',
        columns : [
            {data: 'name'},
            {data: 'action', orderable: false, searchable: false}
        ],
        pageLength: 30,
        lengthMenu: [
            [5, 10, 20, 30, 50, 100],
            [5, 10, 20, 30, 50, 100],
        ],
        autoWidth: !1,
    });
    $(document).on('click', '[id=btn-edit]', function(){
        var id = $(this).data('id');
        var show_route = '{{ route('lead-source.show', ':id') }}';
        var update_route = '{{ route('lead-source.update', ':id') }}';
        show_route = show_route.replace(':id', id);
        update_route = update_route.replace(':id', id);
        if (id) {
            $.ajax({
                method: 'get',
                url: show_route,
                jsonp: false,
                success: function(result) {
                    $('[id=id]').val(result.id);
                    $('[id=name]').val(isset(result.name));
                    $("[id=update-form]").attr("action", update_route);
                    $('[id=edit-modal]').modal();
                }
            });
        }
    });
</script>
@endsection
