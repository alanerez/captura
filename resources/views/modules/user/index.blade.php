@extends('layouts.lucid')
@section('breadcrumbs')
{{ Breadcrumbs::render('user.index') }}
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/select2/select2.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>User</h2>
                    <hr>
                    @permission('add-user')
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#add-modal">Add New User</button>
                    @endpermission
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" id="datatable">
                            <thead>
                                <tr>
                                    <th><i class="icon-user"></i></th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th><i class="far fa-user"></i></th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@permission('edit-user')
@include('user::includes._modal_edit')
@endpermission
@permission('add-user')
@include('user::includes._modal_add')
@endpermission
@endsection
@section('scripts')
<script src="{{ asset('/lucid/light/assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('/lucid/assets/vendor/select2/select2.min.js') }}"></script>
<script>
    var roles = @json($roles);
    jQuery("#datatable").dataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('user.index') }}',
        columns : [
            {data: 'profile_picture', orderable: false, searchable: false},
            {data: 'last_name'},
            {data: 'first_name'},
            {data: 'middle_name'},
            {data: 'username'},
            {data: 'email'},
            {data: 'role'},
            {data: 'action', orderable: false, searchable: false}
        ],
        columnDefs: [
            {targets: 0, className: "text-center", width: "10%" },
        ],
        order: [
            [ 1, "desc" ]
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
        var show_route = '{{ route('user.show', ':id') }}';
        var update_route = '{{ route('user.update', ':id') }}';
        show_route = show_route.replace(':id', id);
        update_route = update_route.replace(':id', id);
        if (id) {
            $.ajax({
                method: 'get',
                url: show_route,
                jsonp: false,
                success: function(result) {
                    console.log(result);
                    $('[id=id]').val(result.id);
                    $('[id=first_name]').val(result.first_name);
                    $('[id=last_name]').val(result.last_name);
                    $('[id=middle_name]').val(result.middle_name);
                    $('[id=email]').val(result.email);
                    $("[id=roles]").val(result.roles).trigger("change");
                    $("[id=update-form]").attr("action", update_route);
                    $('[id=edit-modal]').modal();
                }
            });
        }
    });
    jQuery(".js-select2:not(.js-select2-enabled)").each(function(e, a) {
        var t = jQuery(a);
        t.addClass("js-select2-enabled").select2({
            width: "100%",
            placeholder: t.data("placeholder") || !1
        })
    })
</script>
@endsection
