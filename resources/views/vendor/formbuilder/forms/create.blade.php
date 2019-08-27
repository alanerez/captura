@extends('formbuilder::layout')
@section('breadcrumbs')
{{ Breadcrumbs::render('form.index') }}
@endsection
@section('content')
<div class="container-fluid">
  <div class="row clearfix">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">
          {{ $pageTitle ?? '' }}
          <a href="{{ route('form.index') }}" class="btn btn-sm btn-primary float-md-right">
            <i class="fa fa-arrow-left"></i> Back To Web2Lead
          </a>
          </h5>
            <div class="alert d-none">
                <div class="alert success-message alert-success"></div>
            </div>
        </div>
        <form action="{{ $saveURL }}" method="POST" id="createFormForm">
          @csrf
          <div class="card-body">
            <div class="row">
              <input type="hidden" name="visibility" id="visibility" value="PUBLIC">
              <input type="hidden" name="allows_edit" id="allows_edit" value="0">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name" class="col-form-label">Form Name</label>
                  <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter Form Name">
                  @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="submit_button_text" class="col-form-label">Submit Button Text</label>
                  <input id="submit_button_text" type="text" class="form-control{{ $errors->has('submit_button_text') ? ' is-invalid' : '' }}" name="submit_button_text" value="{{ old('submit_button_text') }}" required autofocus placeholder="Enter Submit Button Text">
                  @if ($errors->has('submit_button_text'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('submit_button_text') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="redirect_url" class="col-form-label">Redirect url to show after form is succcesfully submitted</label>
                  <input id="redirect_url" type="text" class="form-control{{ $errors->has('redirect_url') ? ' is-invalid' : '' }}" name="redirect_url" value="{{ old('redirect_url') }}" required autofocus placeholder="Enter Redirect Url">
                  @if ($errors->has('redirect_url'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('redirect_url') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="message" class="col-form-label">Success Message</label>
                  <textarea id="message" type="text" class="form-control{{ $errors->has('submit_button_text') ? ' is-invalid' : '' }}" name="message" required autofocus placeholder="Success Message">{{ old('message') }}</textarea>
                  @if ($errors->has('message'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('message') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="source_id" class="col-form-label">Source</label>
                  <div class="input-group">
                      <select name="source_id" id="source_id" class="form-control" required="required">
                        <option value="" selected="">Select Source</option>
                        @foreach(Modules\GlobalSetting\Entities\GlobalSetting::where('key', 'lead_source')->get() as $lead_source)
                        <option value="{{ $lead_source->id }}">{{ json_decode($lead_source->value)->name }}</option>
                        @endforeach
                          @permission('add-lead-source')
                          <option value="source-modal" style="color: #0d97ff;">Add New</option>
                          @endpermission
                      </select>
                  </div>
                  @if ($errors->has('source_id'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('source_id') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="type_id" class="col-form-label">Type</label>
                  <div class="input-group">
                      <select name="type_id" id="type_id" class="form-control" required="required">
                        <option value="" selected="">Select Type</option>
                        @foreach(Modules\GlobalSetting\Entities\GlobalSetting::where('key', 'lead_type')->get() as $lead_type)
                        <option value="{{ $lead_type->id }}">{{ json_decode($lead_type->value)->name }}</option>
                        @endforeach
                          @permission('add-lead-type')
                          <option value="type-modal" style="color: #0d97ff;">Add New</option>
                          @endpermission
                      </select>
                  </div>
                  @if ($errors->has('type_id'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type_id') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group">
                  <label for="department_id" class="col-form-label">Department</label>
                  <div class="input-group">
                  <select name="department_id" id="department_id" class="form-control" required="required">
                    <option value="" selected="">Select Department</option>
                    @foreach(Modules\Department\Entities\Department::all() as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                      @permission('add-department')
                      <option value="department-modal" data-toggle="modal" data-target=".add-department-modal"  style="color: #0d97ff;">Add New</option>
                      @endpermission
                  </select>
                  </div>
                  @if ($errors->has('department_id'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('department_id') }}</strong>
                  </span>
                  @endif
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-12">
                <div class="alert alert-info" role="alert">
                  <i class="fa fa-info-circle"></i>
                  Click on or drag and drop components onto the main panel to build your form content.
                </div>
                <div id="fb-editor" class="fb-editor"></div>
              </div>
            </div>
          </div>
        </form>
        <div class="card-footer" id="fb-editor-footer" style="display: none;">
          <button type="button" class="btn btn-primary fb-clear-btn">
          <i class="fa fa-remove"></i> Clear Form
          </button>
          <button type="button" class="btn btn-primary fb-save-btn">
          <i class="fa fa-save"></i> Submit &amp; Save Form
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="backdrop"></div>
@permission('add-lead-source')
@include('includes._modal_add_source')
@endpermission
@permission('add-lead-type')
@include('includes._modal_add_type')
@endpermission
@permission('add-department')
@include('includes._modal_add_department')
@endpermission

@endsection
@section('scripts')
    <script>
        $('.close-modal').on('click', function () {
            $('.add-source-modal').modal('hide');
            $('.add-type-modal').modal('hide');
            $('.add-department-modal').modal('hide');
            $('.add-source-modal').removeClass('modal-custom');
            $('.add-type-modal').removeClass('modal-custom');
            $('.add-department-modal').removeClass('modal-custom');
            $('body').find('.modal-dialog').removeClass('modal-show');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        })
        $('select').on('change', function () {
            var id = $(this).val();
            if(id == 'source-modal'){
                $('.add-source-modal').modal('show');
                $('.add-source-modal').addClass('modal-custom');
                $('.modal-dialog').addClass('modal-show');
                $('.backdrop').addClass('modal-backdrop');
            }else if(id == 'type-modal'){
                $('.add-type-modal').modal('show');
                $('.add-type-modal').addClass('modal-custom');
                $('.modal-dialog').addClass('modal-show');
                $('.backdrop').addClass('modal-backdrop');
            }else if(id == 'department-modal'){
                $('.add-department-modal').modal('show');
                $('.add-department-modal').addClass('modal-custom');
                $('.modal-dialog').addClass('modal-show');
                $('.backdrop').addClass('modal-backdrop');
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

@push(config('formbuilder.layout_css_stack', 'styles'))
@endpush

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
    </script>
    <script src="{{ asset('vendor/formbuilder/js/create-form.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
@endpush
