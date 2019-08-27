@permission('edit-role')
<button type="button" data-id="{{ $role->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-role')
<form style="display:inline;" method="POST" action="{{ route('role.destroy', $role->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
