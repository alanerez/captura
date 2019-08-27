@permission('edit-lead-type')
<button type="button" data-id="{{ $lead_type->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-lead-type')
<form style="display:inline;" method="POST" action="{{ route('lead-type.destroy', $lead_type->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
