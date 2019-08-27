<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <p class="mb-0">{{ Session::get('success') }}</p>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <p class="mb-0">{{ Session::get('error') }}</p>
            </div>
            @endif
            @if($errors->any())
            @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <p class="mb-0">{{ $error }}</p>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
