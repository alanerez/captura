@extends('formbuilder::layout')
@section('breadcrumbs')
{{ Breadcrumbs::render('form.index') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home">Preview</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Profile">Form Information & Integration Code</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="Home">
                            <h4>
                            Form Preview
                            <div class="btn-toolbar float-md-right" role="toolbar">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('form.index') }}" class="btn btn-primary float-md-right btn-sm">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                    <a href="{{ route('form.submission.index', $form) }}" class="btn btn-primary float-md-right btn-sm">
                                        <i class="fa fa-th-list"></i> Leads
                                    </a>
                                    <a href="{{ route('form.create') }}" class="btn btn-primary float-md-right btn-sm">
                                        <i class="fa fa-plus-circle"></i> New Form
                                    </a>
                                    <button class="btn btn-primary btn-sm clipboard float-right" data-clipboard-text="{{ route('form.render', $form->identifier) }}" data-message="Copied" data-original="Copy Form URL" title="Copy form URL to clipboard">
                                    <i class="fa fa-clipboard"></i> Copy Form URL
                                    </button>
                                </div>
                            </div>
                            </h4>
                            <br>
                            <div class="card-body">
                                <div id="fb-render"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="Profile">
                            <h4>Form Information & Integration Code</h4>
                            <br>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Public URL: </strong>
                                    <a href="{{ route('form.render', $form->identifier) }}" class="float-right" target="_blank">
                                        {{$form->identifier}}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Current Submissions: </strong>
                                    <span class="float-right">{{ $form->submissions_count }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Last Updated On: </strong>
                                    <span class="float-right">
                                        {{ $form->updated_at->toDayDateTimeString() }}
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Created On: </strong>
                                    <span class="float-right">
                                        {{ $form->created_at->toDayDateTimeString() }}
                                    </span>
                                </li>
                            </ul>
                            <div class="card-body">
                                <h3>Integration Code </h3>
                                <hr><br>
                                <p>Copy &amp; Paste the code anywhere in your site to show the form, additionally you can adjust the width and height px to fit for your website.</p>
                                <textarea readonly="" class="form-control" rows="5">&lt;iframe width="600" height="850" src="{{ route('form.render', $form->identifier) }}" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('vendor/formbuilder/js/preview-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
