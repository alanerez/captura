@extends('layouts.lucid')

@section('content')

    <div class="container">
        <div class="card p-3 mt-5">
            <section class="content-header">
                <h1>
                    Edit Lead
                </h1>
            </section>
            <div class="content">
                <div class="box box-primary">
                    <div class="box-body">

                        <div class="row">
                            {!! Form::model($purl, ['route' => ['lead-management.update', $purl->id], 'method' => 'patch']) !!}

                            @include('lead_management.fields')

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection