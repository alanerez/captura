<!doctype html>
<html lang="en">
    <head>
        @include('partials.lucid._head')
        @stack('styles')
    </head>
    <body class="theme-cyan">
        @include('partials.lucid._page_loader')
        <div id="wrapper">
            <div id="app">
                @include('partials.lucid._nav')
                @include('partials.lucid._sidenav')
                <div id="main-content">
                    <div class="container-fluid">
                        @yield('breadcrumbs')
                    </div>
                    @include('includes._alert_message')
                    @yield('content')
                </div>
            </div>
        </div>
        @include('partials.lucid._scripts')
        @stack('scripts')
    </body>
</html>
