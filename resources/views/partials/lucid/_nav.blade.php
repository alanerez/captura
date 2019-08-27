<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
        </div>
        <div class="navbar-brand">
            <a href="{{ route('dashboard') }}"><img src="{{ asset('/img/logo.png') }}" alt="Lucid Logo" class="img-responsive logo"></a>
        </div>
        <div class="navbar-right">
            <form id="navbar-search" class="navbar-form search-form">
                <input value="" class="form-control" placeholder="Search here..." type="text">
                <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
            </form>
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#" class="icon-menu" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
