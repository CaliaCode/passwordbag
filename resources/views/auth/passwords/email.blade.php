@extends('layouts.auth')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div id="login-box">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <img src="{{ asset(config('settings.app_logo')) }}" alt="">
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="login" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div>
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-12 sr-only">E-Mail Address</label>

                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Password" required>

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
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
