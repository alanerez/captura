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
                        <p class="lead">Reset Password</p>
                    </div>
                    <div class="body">
                        <form method="POST" class="form-auth-small" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <input type="email" readonly class="form-control" placeholder="Email Address" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">RESET PASSWORD</button>
                            <div class="bottom">
                                <span class="helper-text">Know your password? <a href="{{ route('login') }}">Login</a></span>
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
