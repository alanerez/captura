<select class="form-control lead-status" data-id="{{$lead->id}}">
    @foreach($lead_statuses as $status)
    @php
        $status_value = @json_decode($status->value);
    @endphp
    <option value="{{$status->id}}" {{ @$lead->status_id == $status->id ? 'selected' : '' }}>{{ $status_value->name }}</option>
    @endforeach
</select>
