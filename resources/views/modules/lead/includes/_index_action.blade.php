{{-- @permission('edit-lead')
<button type="button" data-id="{{ $lead->id }}" id="btn-edit" class="btn btn-sm btn-secondary">Edit</button>
@endpermission --}}
<a href="{{ route('form.submission.show', [$lead->form, $lead->id]) }}" class="btn btn-sm btn-secondary" title="View submission">
    <i class="fa fa-eye"></i> View
</a>
@permission('delete-lead')
<form style="display:inline;" method="POST" action="{{ route('form.submission.destroy', [$lead->form, $lead->id]) }}" onsubmit="return confirm('Are you sure you want to delete this?')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-sm btn-secondary">Delete</button>
</form>
@endpermission
