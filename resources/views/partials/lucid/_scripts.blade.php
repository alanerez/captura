
<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/lucid/light/assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('/lucid/light/assets/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('/lucid/light/assets/bundles/mainscripts.bundle.js') }}"></script>
@yield('scripts')
<script>
    function isset(obj) {
        return (typeof obj !=='undefined') ? obj : null;
    }
</script>
