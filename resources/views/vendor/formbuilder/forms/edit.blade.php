@extends('formbuilder::layout')
@section('breadcrumbs')
{{ Breadcrumbs::render('form.index') }}
@endsection
@section('content')
<div class="container-fluid">
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="btn-toolbar float-md-right" role="toolbar">
        <div class="btn-group" role="group">
          <a href="{{ route('form.index') }}" class="btn btn-sm btn-primary float-md-right">
            <i class="fa fa-arrow-left"></i> Back To Web2Lead
          </a>
          <button class="btn btn-primary btn-sm clipboard" data-clipboard-text="{{ route('form.render', $form->identifier) }}" data-message="Link Copied" data-original="Copy Form Link" title="Copy form URL to clipboard">
          <i class="fa fa-clipboard"></i> Copy Form Link
          </button>
        </div>
      </div>
      <br>
      <br>
      <div class="card">
        <div class="body">
          <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Home">Form Information & Form Builder</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Profile">Integration Code</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#webhooks">Webhook</a></li>
          </ul>
          <div class="tab-content">
            @include('formbuilder::forms.includes._tab_form_builder')
            @include('formbuilder::forms.includes._tab_integration_code')
            <div class="tab-pane" id="webhooks">
              <webhook-add></webhook-add>
              <webhook-list></webhook-list>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push(config('formbuilder.layout_css_stack', 'styles'))
<script type="text/javascript">
  window.form_id = '{{ $form->id }}';
</script>
@endpush
@section('scripts')
    <script>
        $('select').on('change', function () {
            var id = $(this).val();
            if(id == 'department-modal'){
                $('#add-department-modal').modal('show');
            }else if(id == 'source-modal'){
                $('#add-source-modal').modal('show');
            }else if(id == 'type-modal'){
                $('#add-type-modal').modal('show');
            }
        })
        $('#save-source-form-btn').on('click', function () {
            var source_name = $(".source_name").val();

            $.ajax({
                type: 'POST',
                url: "/lead-source/storeFromWeb2Lead",
                data: {
                    value: {name: source_name},
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    $('#add-source-modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $(".alert").find('.success-message').text("Lead Source has been created successfully.");
                    $(".alert").removeClass('d-none');
                    $(".alert").fadeIn("slow",function(){
                        setTimeout(function(){
                            $(".alert").fadeOut("slow");
                            $(".alert").addClass('d-none');
                        },3000);
                    });
                    var added = $("#source_id").append(new Option(source_name, res['id'], true, true));
                    return false;
                },
            })
        });

        $('#save-type-form-btn').on('click', function () {
            var type_name = $(".type_name").val();

            $.ajax({
                type: 'POST',
                url: "/lead-type/storeFromWeb2Lead",
                data: {
                    value: {name: type_name},
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    $('#add-type-modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $(".alert").find('.success-message').text("Lead Type has been created successfully.");
                    $(".alert").removeClass('d-none');
                    $(".alert").fadeIn("slow",function(){
                        setTimeout(function(){
                            $(".alert").fadeOut("slow");
                            $(".alert").addClass('d-none');
                        },3000);
                    });
                    $("#type_id").append(new Option(type_name, res['id'], true, true));
                    return false;
                },
            })
        });

        $('#save-department-form-btn').on('click', function () {
            var incoming_host = $(".incoming_host").val();
            var incoming_protocol = $(".incoming_protocol:checked").val();
            var incoming_encryption = $(".incoming_encryption:checked").val();
            var outgoing_host = $(".outgoing_host").val();
            var outgoing_host = $(".outgoing_host").val();
            var outgoing_encryption = $(".outgoing_encryption:checked").val();
            var name = $(".name").val();
            var email = $(".email").val();
            var username = $(".username").val();
            var password = $(".password").val();

            $.ajax({
                type: 'POST',
                url: "/department/storeFromWeb2Lead",
                data: {
                    incoming_host: incoming_host,
                    incoming_protocol: incoming_protocol,
                    incoming_encryption: incoming_encryption,
                    outgoing_host: outgoing_host,
                    outgoing_encryption: outgoing_encryption,
                    name: name,
                    email: email,
                    username: username,
                    password: password,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    $('#add-department-modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $(".alert").find('.success-message').text("Department has been created successfully.");
                    $(".alert").removeClass('d-none');
                    $(".alert").fadeIn("slow",function(){
                        setTimeout(function(){
                            $(".alert").fadeOut("slow");
                            $(".alert").addClass('d-none');
                        },3000);
                    });
                    $("#department_id").append(new Option(name, res['id'], true, true));
                    return false;
                },
            })
        })
    </script>
@endsection

@push(config('formbuilder.layout_js_stack', 'scripts'))
    <script type="text/javascript">

        window.FormBuilder = window.FormBuilder || {}

        window.FormBuilder.fields = [
            {
              label: "Name",
              type: "text",
              name: 'name'
            },
            {
              label: "Position",
              type: "text",
              name: 'position'
            },
            {
              label: "Email Address",
              type: "text",
              subtype: "email",
              name: 'email_address'
            },
            {
              label: "Phone",
              type: "text",
              name: 'phone'
            },
            {
              label: "Company",
              type: "text",
              name: 'company'
            },
            {
              label: "Address",
              type: "textarea",
              name: 'address'
            },
            {
              label: "City",
              type: "text",
              name: 'city'
            },
            {
              label: "State",
              type: "text",
              name: 'state'
            },
            {
              label: "Country",
              type: "select",
              name: 'country',
              values: @json($countries)
            },
            {
              label: "Zip Code",
              type: "text",
              name: 'zip_code'
            },
            {
              label: "Title",
              type: "text",
              name: 'title'
            },
            {
              label: "Description",
              type: "textarea",
              name: 'description'
            },
            {
              label: "Website",
              type: "text",
              name: 'website'
            },
        ];

        window._form_builder_content = {!! json_encode($form->form_builder_json) !!}
    </script>
    <script src="{{ asset('vendor/formbuilder/js/create-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
