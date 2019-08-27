@permission('edit-lead-status')
<button type="button" data-id="{{ $lead_status->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-lead-status')
<form style="display:inline;" method="POST" action="{{ route('lead-status.destroy', $lead_status->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
