<div class="table-responsive">
    <table class="table" id="cashRegsiters-table">
        <thead>
        <tr>
            <th>Monthly Debt</th>
            <th>Deals (Transactions)</th>
            <th>Monthly Income</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($goals as $goal)
            <tr>
                <td>$ {!! number_format($goal->monthly_debt, 2) !!}</td>
                <td>{!! number_format($goal->transactions, 2) !!}</td>
                <td>$ {!! number_format($goal->monthly_income) !!}</td>
                <td>
                    <div class='btn-group'>
                        {{--                        <a href="{!! route('goal.show', [$goal->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>--}}
                        {!! Form::open(['route' => ['goal.destroy', $goal->id], 'method' => 'delete']) !!}
{{--                        <button class="btn btn-default" data-toggle="modal" data-target="#edit_goal_modal_{{$goal->id}}"><i class="glyphicon glyphicon-edit"></i></button>--}}
                        <a href="{!! route('goal.edit', [$goal->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
{{--            <div class="modal fade" id="edit_goal_modal_{{$goal->id}}" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">--}}
{{--                <div class="modal-dialog" role="document">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h5 class="modal-title" id="modal_label">Edit Goal</h5>--}}
{{--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                <span aria-hidden="true">&times;</span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="modal-body">--}}
{{--                            {!! Form::open(['route' => 'goal.edit', $goal->id]) !!}--}}
{{--                            <div class="col-sm-12 pr-5 pl-5">--}}
{{--                                <div class="row">--}}
{{--                                    {{ Form::hidden('id', $goal->id) }}--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('Monthly Debt Goal:') !!}--}}
{{--                                        {!! Form::number('monthly_debt', $goal->monthly_debt, ['class' => 'form-control', 'id' => 'monthly_debt', 'required']) !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('Transactions Goal:') !!}--}}
{{--                                        {!! Form::number('transactions', $goal->transactions, ['class' => 'form-control', 'id' => 'transactions', 'required']) !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('Monthly Income Goal:') !!}--}}
{{--                                        {!! Form::number('monthly_income', $goal->monthly_income, ['class' => 'form-control', 'id' => 'monthly_income', 'required']) !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('Growth Goal(1 - 100):') !!}--}}
{{--                                        {!! Form::number('growth', $goal->growth, ['class' => 'form-control', 'id' => 'growth', 'required']) !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row float-right">--}}
{{--                                    <a href="{!! route('cash-register.dashboard') !!}" class="btn btn-default m-1">Cancel</a>--}}
{{--                                    {!! Form::submit('Save', ['class' => 'btn btn-primary m-1', 'id' => 'save-goal']) !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            {!! Form::close() !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        @endforeach
        </tbody>
    </table>
</div>
