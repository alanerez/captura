<!doctype html>
<html lang="en">
    <head>
        @stack('styles')
    </head>
    <body>
        @yield('content')
        @stack('scripts')
    </body>
</html>
