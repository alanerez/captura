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
                            <p class="lead">Recover my password</p>
                        </div>
                        <div class="body">
                            <p>Please enter your email address below to receive instructions for resetting password.</p>
                            <form method="POST" class="form-auth-small" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address">
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Send Password Reset Link</button>
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
