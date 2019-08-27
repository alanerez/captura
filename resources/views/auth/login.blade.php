@extends('layouts.lucid_auth')
@section('content')
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle auth-main">
            <div class="auth-box">
                <div class="top">
                    <img src="{{ asset('/img/logo-white.png') }}" alt="Lucid">
                </div>
                <div class="card">
                    <div class="header">
                        <p class="lead">Login to your account</p>
                    </div>
                    <div class="body">
                        <form method="POST" class="form-auth-small" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">Email</label>
                                <input type="email" class="form-control" name="email" id="signin-email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="signin-password" class="control-label sr-only">Password</label>
                                <input type="password" class="form-control" name="password" id="signin-password" placeholder="Password">
                            </div>
                            <div class="form-group clearfix">
                                <label class="fancy-checkbox element-left">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span>Remember me</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                            <div class="bottom">
                                <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="{{ route('password.request') }}">Forgot password?</a></span>
                                {{-- <span>Don't have an account? <a href="page-register.html">Register</a></span> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@include('includes._notification_message')
@endsection
