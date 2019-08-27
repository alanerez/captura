@permission('edit-permission')
<button type="button" data-id="{{ $permission->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-permission')
<form style="display:inline;" method="POST" action="{{ route('permission.destroy', $permission->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
