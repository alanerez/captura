<select class="form-control lead-type" data-id="{{$lead->id}}">
    @foreach($lead_types as $type)
    @php
        $type_value = @json_decode($type->value);
    @endphp
    <option value="{{$type->id}}" {{ @$lead->type_id == $type->id ? 'selected' : '' }}>{{ $type_value->name }}</option>
    @endforeach
</select>
