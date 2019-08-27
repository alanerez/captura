@extends('formbuilder::layout')
@section('breadcrumbs')
{{ Breadcrumbs::render('form.submission.index', $form) }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">
                    {{ $pageTitle }} ({{ $submissions->count() }})
                    <a href="{{ route('form.index') }}" class="btn btn-primary float-md-right btn-sm">
                        <i class="fa fa-arrow-left"></i> Back To Web2Lead
                    </a>
                    </h5>
                </div>
                @if($submissions->count())
                <div class="table-responsive">
                    <table class="table table-bordered d-table table-striped pb-0 mb-0">
                        <thead>
                            <tr>
                                <th class="five">#</th>
                                @foreach($form_headers as $header)
                                <th>{{ $header['label'] ?? title_case($header['name']) }}</th>
                                @endforeach
                                <th class="fifteen">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $submission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @foreach($form_headers as $header)
                                <td>
                                    {{
                                    $submission->renderEntryContent(
                                    $header['name'], $header['type'], true
                                    )
                                    }}
                                </td>
                                @endforeach
                                <td>
                                    <a href="{{ route('form.submission.show', [$form, $submission->id]) }}" class="btn btn-primary btn-sm" title="View submission">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <form action="{{ route('form.submission.destroy', [$form, $submission]) }}" method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm confirm-form" data-form="deleteSubmissionForm_{{ $submission->id }}" data-message="Delete this submission?" title="Delete submission">
                                        <i class="fa fa-trash-o"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($submissions->hasPages())
                <div class="card-footer mb-0 pb-0">
                    <div>{{ $submissions->links() }}</div>
                </div>
                @endif
                @else
                <div class="card-body">
                    <h4 class="text-danger text-center">
                    No lead to display.
                    </h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
