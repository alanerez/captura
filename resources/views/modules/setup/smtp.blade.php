@extends('layouts.lucid')
@section('breadcrumbs')
{{ Breadcrumbs::render('setup') }}
@endsection
@section('styles')

@endsection
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        @include('setup::includes.sidenav')
        <div class="col-lg-9">
            <div class="card">
                <div class="header">
                    <h2>SMTP</h2>
                </div>
                <div class="body">
                    <form id="save-form" method="POST" action="{{ route('setup.save') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ @$smtp->id }}">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label>Host</label>
                                    <input type="text" class="form-control" name="value[host]" value="{{ @$smtp->host }}" placeholder="Host" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label>Port</label>
                                    <input type="text" class="form-control" name="value[port]" value="{{ @$smtp->port }}" placeholder="Port" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="value[username]" value="{{ @$smtp->username }}" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="value[password]" value="{{ @$smtp->password }}" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <p class="mb-0">Encryption</p>
                                    <label class="fancy-radio"><input name="value[encryption]" value="tls" type="radio" {{ @$smtp->encryption == 'tls' ? 'checked' : '' }}><span><i></i>TLS</span></label>
                                    <label class="fancy-radio"><input name="value[encryption]" value="ssl" type="radio" {{ @$smtp->encryption == 'ssl' ? 'checked' : '' }}><span><i></i>SSL</span></label>
                                    <label class="fancy-radio"><input name="value[encryption]" value="false" type="radio" {{ @$smtp->encryption == false ? 'checked' : '' }}><span><i></i>No Encryption</span></label>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <button type="submit" class="btn btn-lg btn-success float-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection
