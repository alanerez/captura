@permission('edit-lead-source')
<button type="button" data-id="{{ $lead_source->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-lead-source')
<form style="display:inline;" method="POST" action="{{ route('lead-source.destroy', $lead_source->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
