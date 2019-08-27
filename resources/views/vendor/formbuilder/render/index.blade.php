@extends('layouts.form_render')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('form.submit', $form->identifier) }}" method="POST" id="submitForm" enctype="multipart/form-data">
                @csrf
                <div id="fb-render"></div>
                <button type="submit" class="btn btn-primary" data-form="submitForm" data-message="Submit your entry for '{{ $form->name }}'?">
                {{ $form->submit_button_text }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
    <script src="{{ asset('/lucid/light/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('/lucid/light/assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ asset('/lucid/light/assets/bundles/mainscripts.bundle.js') }}"></script>
    <script type="text/javascript">
        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('vendor/formbuilder/js/render-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush

@prepend(config('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">
        window.FormBuilder = {
            csrfToken: '{{ csrf_token() }}',
        }
    </script>
    <script src="{{ asset('vendor/formbuilder/js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/sweetalert.min.js') }}" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-builder.min.js') }}" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-render.min.js') }}" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/parsleyjs/parsley.min.js') }}" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/clipboard/clipboard.min.js') }}?b=ck24" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/moment.js') }}"></script>
    <script src="{{ asset('vendor/formbuilder/js/footable/js/footable.min.js') }}" defer></script>
    <script src="{{ asset('vendor/formbuilder/js/script.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endprepend

@prepend(config('formbuilder.layout_css_stack', 'styles'))
    <link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lucid/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/formbuilder/js/footable/css/footable.standalone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/formbuilder/css/styles.css') }}{{ jazmy\FormBuilder\Helper::bustCache() }}">
@endprepend
