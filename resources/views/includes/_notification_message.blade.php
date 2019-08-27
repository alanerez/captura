<script>
    $(function() {
        toastr.options.timeOut = "false";
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-top-right';
        @if(Session::has('status'))
        toastr['success']('{{ Session::get('status') }}');
        @endif

        @if(Session::has('error'))
        toastr['error']('{{ Session::get('error') }}');
        @endif

        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr['error']('{{ $error }}');
        @endforeach
        @endif
    });
</script>
