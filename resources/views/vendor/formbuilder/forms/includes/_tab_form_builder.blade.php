<div class="tab-pane show active" id="Home">
  <div class="alert d-none">
    <div class="alert success-message alert-success"></div>
  </div>
  <form action="{{ $saveURL }}" method="POST" id="createFormForm" data-form-method="PUT">
    @csrf
    @method('PUT')
    <div class="row">
      <input type="hidden" name="visibility" id="visibility" value="PUBLIC">
      <input type="hidden" name="allows_edit" id="allows_edit" value="0">
      <div class="col-md-6">
        <div class="form-group">
          <label for="name" class="col-form-label">Form Name</label>
          <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?? $form->name }}" required autofocus placeholder="Enter Form Name">
          @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label for="submit_button_text" class="col-form-label">Submit Button Text</label>
          <input id="submit_button_text" type="text" class="form-control{{ $errors->has('submit_button_text') ? ' is-invalid' : '' }}" name="submit_button_text" value="{{ old('submit_button_text') ?? $form->submit_button_text }}" required autofocus placeholder="Enter Submit Button Text">
          @if ($errors->has('submit_button_text'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('submit_button_text') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label for="redirect_url" class="col-form-label">Redirect url to show after form is succcesfully submitted</label>
          <input id="redirect_url" type="text" class="form-control{{ $errors->has('redirect_url') ? ' is-invalid' : '' }}" name="redirect_url" value="{{ old('redirect_url') ?? $form->redirect_url }}" required autofocus placeholder="Enter Redirect Url">
          @if ($errors->has('redirect_url'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('redirect_url') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label for="message" class="col-form-label">Success Message</label>
          <textarea id="message" type="text" class="form-control{{ $errors->has('submit_button_text') ? ' is-invalid' : '' }}" name="message" required autofocus placeholder="Success Message">{{ old('message') ?? $form->message }}</textarea>
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
          <select name="source_id" id="source_id" class="form-control" required="required">
            <option value="" disabled="" selected="">Select Source</option>
            @foreach(Modules\GlobalSetting\Entities\GlobalSetting::where('key', 'lead_source')->get() as $lead_source)
              <option value="{{ $lead_source->id }}" @if($form->source_id == $lead_source->id) selected @endif>{{ json_decode($lead_source->value)->name }}</option>
            @endforeach
            @permission('add-lead-source')
            <option value="source-modal" style="color: #0d97ff;">Add New</option>
            @endpermission
          </select>
          @if ($errors->has('source_id'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('source_id') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label for="type_id" class="col-form-label">Type</label>
          <select name="type_id" id="type_id" class="form-control" required="required">
            <option value="" disabled="" selected="">Select Type</option>
            @foreach(Modules\GlobalSetting\Entities\GlobalSetting::where('key', 'lead_type')->get() as $lead_type)
              <option value="{{ $lead_type->id }}"  @if($form->type_id == $lead_type->id) selected @endif>{{ json_decode($lead_type->value)->name }}</option>
            @endforeach
            @permission('add-lead-type')
            <option value="type-modal" style="color: #0d97ff;">Add New</option>
            @endpermission
          </select>
          @if ($errors->has('type_id'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('type_id') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group">
          <label for="department_id" class="col-form-label">Department</label>
          <select name="department_id" id="department_id" class="form-control" required="required">
            <option value="" disabled="" selected="">Select Department</option>
            @foreach(Modules\Department\Entities\Department::all() as $department)
              <option value="{{ $department->id }}"  @if($form->department_id == $department->id) selected @endif>{{ $department->name }}</option>
            @endforeach
            @permission('add-department')
            <option value="department-modal" style="color: #0d97ff;">Add New</option>
            @endpermission
          </select>
          @if ($errors->has('department_id'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('department_id') }}</strong>
          </span>
          @endif
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="alert alert-info" role="alert">
          <i class="fa fa-info-circle"></i>
          Click on or Drag and drop components onto the main panel to build your form content.
        </div>
        <div id="fb-editor" class="fb-editor"></div>
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
@permission('add-department')
@include('includes._modal_add_department')
@endpermission
@permission('add-lead-type')
@include('includes._modal_add_type')
@endpermission
@permission('add-lead-source')
@include('includes._modal_add_source')
@endpermission
