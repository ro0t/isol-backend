@extends('layouts.app')

@section('content')

<div class="container" id="login">
    <div class="logo"></div>

    <div class="login-container">

        <div class="login-text">
            <span class="header">Log in</span>
            <span class="sub">IGITAL WEB MANAGER</span>
        </div>

        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="email form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="password form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" name="password" required>
            </div>

            <div class="input-errors">
                @if($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="btn btn-rounded btn-primary">
                            Login
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <a href="http://igital.co" target="_blank" class="made-by"></a>
</div>
@endsection
