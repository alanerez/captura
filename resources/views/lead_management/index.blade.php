@extends('layouts.lucid')

@section('content')
    <div id="content">
        <div class="container">
            <div class="card p-3 mt-5">
                <section class="content-header">
                    <h1 class="pull-left">Lead Management</h1>
                    <h1 class="pull-right">
                        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('lead-management.create') !!}">Add New Lead</a>
                    </h1>
                </section>
                <div class="content">
                    <div class="clearfix"></div>
                    <hr>
                    @include('flash::message')

                    <div class="clearfix"></div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Search By Customer Number:</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Customer Number:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="cust-id" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label>Or Select an Option:</label>
                                    </div>
                                    <div class="col-md-2">
                                        <select id="selectOption" class="rounded">
                                            <option class="lead-option" value="" selected>SELECT ONE</option>
                                            <option class="lead-option" value="id">ID</option>
                                            <option class="lead-option" value="lastname">Last Name</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" id="select-option-value" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary" id="search-lead-btn">SUBMIT</button>
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
    <script>
        $('#search-lead-btn').on('click', function () {
            var custID = $('#cust-id').val();
            var selectOptionValue = $('#select-option-value').val();
            var selectOption = $('#selectOption').val();

            if(selectOptionValue == "" && custID == ""){
                alert('Please select one from the options or enter a customer ID.')
            }else if(selectOption != "" && selectOptionValue == ""){
                alert('Please select one from the options and enter detail on the box beside.')
            }else if(selectOption == "" && selectOptionValue != ""){
                alert('Please select one from the options and enter detail on the box beside.')
            }else {
                $.ajax({
                    type: 'GET',
                    url: "/lead-management/list/leads",
                    data: {
                        customerid: custID,
                        select_option: selectOption,
                        option_value: selectOptionValue,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        $('#content').html(res).render();
                    }
                })
            }
        })
    </script>
@endsection