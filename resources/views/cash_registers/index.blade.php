@extends('layouts.lucid')

@section('content')
    <div class="container">
        <div class="card p-3 mt-5">
            <section class="content-header">
                <h1 class="pull-left">Daily Transactions</h1>
                <h1 class="pull-right">
                    <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('cash-register.create') !!}">Add New</a>
                </h1>
            </section>
            <div class="content">
                <div class="clearfix"></div>

                @include('flash::message')

                <div class="clearfix"></div>
                <div class="box box-primary">
                    <div class="box-body">
                        @include('cash_registers.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

