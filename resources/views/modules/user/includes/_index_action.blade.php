@permission('edit-user')
<button type="button" data-id="{{ $user->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-user')
<form style="display:inline;" method="POST" action="{{ route('user.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
