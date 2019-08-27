
<div class="container">
    <div class="card p-3 mt-5">
        <section class="content-header">
            <h1 class="pull-left">Lead Management</h1>
        </section>
        <div class="content">
            <div class="clearfix"></div>
            @include('flash::message')

            <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table" id="leadManagement-table">
                                <thead>
                                <tr>
                                    <th>Edit Lead</th>
                                    <th>Customer Number</th>
                                    <th>Phone</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip</th>
                                    <th>Last Update</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($purls as $purl)
                                    <tr>
                                        <td>
                                            <a href="{!! route('lead-management.edit', [$purl->id]) !!}" class='btn btn-warning btn-xs'>Edit Lead</a>
                                        </td>
                                        <td>{!! $purl->customerid !!}</td>
                                        <td>{!! $purl->altphone !!}</td>
                                        <td>{!! $purl->firstname !!}</td>
                                        <td>{!! $purl->lastname !!}</td>
                                        <td>{!! $purl->address !!}</td>
                                        <td>{!! $purl->city !!}</td>
                                        <td>{!! $purl->state !!}</td>
                                        <td>{!! $purl->zip !!}</td>
                                        <td>{!! $purl->updated_at !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>