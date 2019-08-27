@permission('edit-ticket-service')
<button type="button" data-id="{{ $ticket_service->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-ticket-service')
<form style="display:inline;" method="POST" action="{{ route('ticket-service.destroy', $ticket_service->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
