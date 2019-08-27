@permission('edit-department')
<button type="button" data-id="{{ $department->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission
@permission('delete-department')
<form style="display:inline;" method="POST" action="{{ route('department.destroy', $department->id) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
<form style="display:inline;" method="POST" action="{{ route('email.update', $department->id) }}">
    @csrf
    @method('patch')
    <button type="submit" class="btn btn-sm btn-secondary">Test Connect</button>
</form>
