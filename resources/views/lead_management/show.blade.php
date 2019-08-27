@extends('layouts.lucid')

@section('content')
    <div class="container">
        <div class="card mt-5 p-3">
            <section class="content-header">
                <h1>
                    Cash Register
                </h1>
            </section>
            <div class="content">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            @include('cash_registers.show_fields')
                            <a href="{!! route('cash-register.index') !!}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
