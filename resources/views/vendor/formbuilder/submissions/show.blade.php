@extends('formbuilder::layout')
@section('breadcrumbs')
{{ Breadcrumbs::render('form.submission.show', $submission) }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">
                    Viewing Lead #{{ $submission->id }} for form '{{ $submission->form->name }}'
                    <div class="btn-toolbar float-right" role="toolbar">
                        <div class="btn-group" role="group" aria-label="First group">
                            <a href="{{ URL::previous() }}" class="btn btn-primary float-md-right btn-sm" title="Back To Submissions">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                            <form action="{{ route('form.submission.destroy', [$submission->form, $submission]) }}" method="POST" id="deleteSubmissionForm_{{ $submission->id }}" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-0 confirm-form" data-form="deleteSubmissionForm_{{ $submission->id }}" data-message="Delete submission" title="Delete this submission?">
                                <i class="fa fa-trash-o"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    </h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($form_headers as $header)
                    <li class="list-group-item">
                        <strong>{{ $header['label'] ?? title_case($header['name']) }}: </strong>
                        <span class="float-right">
                            {{ $submission->renderEntryContent($header['name'], $header['type']) }}
                        </span>
                    </li>
                    @endforeach
                    <li class="list-group-item">
                        <strong>Form: </strong>
                        <span class="float-right">{{ $submission->form->name }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Last Updated On: </strong>
                        <span class="float-right">{{ $submission->updated_at->toDayDateTimeString() }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Submitted On: </strong>
                        <span class="float-right">{{ $submission->created_at->toDayDateTimeString() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
