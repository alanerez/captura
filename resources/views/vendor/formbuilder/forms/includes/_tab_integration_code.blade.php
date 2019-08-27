<div class="tab-pane" id="Profile">
    <div class="row">
        <div class="col-md-12">
            <p>Copy &amp; Paste the code anywhere in your site to show the form, additionally you can adjust the width and height px to fit for your website.</p>
            <a href="{{ route('form.render', $form->identifier) }}" class="mb-2 btn btn-outline-primary">{{ route('form.render', $form->identifier) }}</a>
            <textarea readonly="" class="form-control" rows="5">&lt;iframe width="600" height="850" src="{{ route('form.render', $form->identifier) }}" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;</textarea>
        </div>
    </div>
</div>
