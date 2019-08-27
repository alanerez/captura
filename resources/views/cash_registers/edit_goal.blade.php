@extends('layouts.lucid')

@section('content')
    <div class="container">
        <div class="card p-3 mt-5">
            <section class="content-header">
                <h1>
                    Edit Goal
                </h1>
            </section>
            <div class="content">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <form action="{{ route('goal.update') }}">
                            <div class="col-sm-12 pr-5 pl-5">
                                <div class="row">
                                    {{ Form::hidden('id', $goal->id) }}
                                    <div class="form-group">
                                        {!! Form::label('Monthly Debt Goal:') !!}
                                        {!! Form::number('monthly_debt', $goal->monthly_debt, ['class' => 'form-control', 'id' => 'monthly_debt', 'required']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        {!! Form::label('Transactions Goal:') !!}
                                        {!! Form::number('transactions', $goal->transactions, ['class' => 'form-control', 'id' => 'transactions', 'required']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        {!! Form::label('Monthly Income Goal:') !!}
                                        {!! Form::number('monthly_income', $goal->monthly_income, ['class' => 'form-control', 'id' => 'monthly_income', 'required']) !!}
                                    </div>
                                </div>
                                <div class="row float-right">
                                    <a href="{!! route('cash-register.goals') !!}" class="btn btn-default m-1">Cancel</a>
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary m-1', 'id' => 'save-goal']) !!}
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection