@extends('layouts.lucid')

@section('content')
    <div class="container">
        <div class="card p-3 mt-5">

            <section class="content-header">
                <h1>
                    Cash Register
                </h1>
            </section>
            <div class="content">
                <div class="box box-primary">

                    <div class="box-body">
                        <div class="row">
                            {!! Form::open(['route' => 'cash-register.store']) !!}

                            @include('cash_registers.fields')

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
