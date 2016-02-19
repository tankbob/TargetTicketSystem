@extends('includes.layout')

@section('sectionTitle')
	Login
@stop

@section('content')
<div class="row">
    <div class="auth-form col-md-8 col-md-offset-2">
        <div class="text-center">
            <a href="{{ url('/') }}" class="target-logo">
                <img src="{{ asset('images/logo.svg') }}" alt="" style="max-width:350px;">
            </a>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-warning">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}

            <div class="form-group">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>

            <div class="form-group">
                <input type="text" class="form-control captcha-input" id="captcha" placeholder="Captcha" name="captcha">
                {!! captcha_img() !!}
            </div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="1"> Remember Me
                </label>
                <a href="{{ url('password/email') }}" class="pull-right">Reset password</a>
            </div>

            <button type="submit" class="btn btn-primary btn-login pull-left">Login</button>
           
        </form>
    </div>
</div>
@endsection
