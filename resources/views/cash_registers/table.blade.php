<div class="table-responsive">
    <table class="table" id="cashRegsiters-table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Daily Debt</th>
            <th>No. of Transactions</th>
            <th>Average Deal Size</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cashRegisters as $cashRegister)
            <tr>
                @php if(is_string($cashRegister->name)){
                $time = strtotime($cashRegister->name);
                $newDate = date('d M Y', $time);
                }else{
                $newDate = $cashRegister->name ;
                }
                @endphp
                <td>{!! $newDate !!}</td>
                <td>$ {!! number_format($cashRegister->cash, 2) !!}</td>
                <td>{!! $cashRegister->transactions !!}</td>
                <td>$ {!! $cashRegister->transactions >= 1 ? number_format($cashRegister->cash / $cashRegister->transactions, 2) : 0 !!}</td>
                <td>
                    {!! Form::open(['route' => ['cash-register.destroy', $cashRegister->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('cash-register.show', [$cashRegister->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('cash-register.edit', [$cashRegister->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
{{--                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
