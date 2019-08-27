@extends('formbuilder::layout')
@section('breadcrumbs')
{{ Breadcrumbs::render('form.index') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card rounded-0">
                <div class="card-header">
                    <h5 class="card-title">
                    {{ $pageTitle ?? '' }}
                    <div class="btn-toolbar float-md-right" role="toolbar">
                        <div class="btn-group" role="group" aria-label="Third group">
                            <a href="{{ route('form.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus-circle"></i> Create a New Form
                            </a>
                        </div>
                    </div>
                    </h5>
                </div>
                @if($forms->count())
                <div class="table-responsive">
                    <table class="table table-bordered d-table table-striped pb-0 mb-0">
                        <thead>
                            <tr>
                                <th class="five">#</th>
                                <th>Name</th>
                                <th>Source</th>
                                <th>Type</th>
                                <th>Department</th>
                                <th class="ten">Submissions</th>
                                <th class="ten">Views</th>
                                <th class="ten">Conversions</th>
                                <th class="twenty-five">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forms as $form)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $form->name }}</td>
                                <td>{{ @json_decode($form->source->value)->name }}</td>
                                <td>{{ @json_decode($form->type->value)->name }}</td>
                                <td>{{ @$form->department->name }}</td>
                                <td>{{ $form->submissions_count }}</td>
                                <td>{{ $form->views == 0 ? 0 : $form->views }}</td>
                                @php
                                    $form->views == 0 ? $conversion = 0 : $conversion = ($form->submissions_count / $form->views) * 100
                                @endphp
                                <td>{{ number_format($conversion) }}%</td>
                                <td>
                                    <a href="{{ route('form.submission.index', $form) }}" class="btn btn-primary btn-sm" title="View submissions for form '{{ $form->name }}'">
                                        <i class="fa fa-th-list"></i> Leads
                                    </a>
                                    <a href="{{ route('form.show', $form) }}" class="btn btn-primary btn-sm" title="Preview form '{{ $form->name }}'">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('form.edit', $form) }}" class="btn btn-primary btn-sm" title="Edit form">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <button class="btn btn-primary btn-sm clipboard" data-clipboard-text="{{ route('form.render', $form->identifier) }}" data-message="" data-original="" title="Copy form URL to clipboard">
                                    <i class="fa fa-clipboard"></i>
                                    </button>
                                    <form action="{{ route('form.destroy', $form) }}" method="POST" id="deleteFormForm_{{ $form->id }}" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm confirm-form" data-form="deleteFormForm_{{ $form->id }}" data-message="Delete form '{{ $form->name }}'?" title="Delete form '{{ $form->name }}'">
                                        <i class="fa fa-trash-o"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($forms->hasPages())
                <div class="card-footer mb-0 pb-0">
                    <div>{{ $forms->links() }}</div>
                </div>
                @endif
                @else
                <div class="card-body">
                    <h4 class="text-danger text-center">
                    No form to display.
                    </h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
