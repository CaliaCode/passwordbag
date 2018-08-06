@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div id="login-box">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <img src="{{ asset(config('settings.app_logo')) }}" alt="">
                </div>
                <div class="panel-body">
                    @if(Session::has('inactive'))
                        <div class="alert alert-danger">{{ Session::get('inactive') }}</div>
                    @endif
                    <form class="app_login-form" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label sr-only">E-Mail Address</label>

                                    <input id="email" type="email" class="form-control" placeholder="E-Mail Address" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block error-help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label sr-only">Password</label>

                                    <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block error-help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="login-section">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="remember-me">
                                        <input type="checkbox" name="remember" id="remember-me">
                                        <label for="remember-me">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary pull-right">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="col-md-12 password-forgot">
                                <a class="btn btn-success" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
