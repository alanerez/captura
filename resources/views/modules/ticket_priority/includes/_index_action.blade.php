@permission('edit-ticket-priority')
<button type="button" data-id="{{ $ticket_priority->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-ticket-priority')
<form style="display:inline;" method="POST" action="{{ route('ticket-priority.destroy', $ticket_priority->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
