@extends('includes.layout')

@section('content')
<div class="row">
    <div class="auth-form col-md-8 col-md-offset-2">
        <div class="text-center">
            <a href="{{ url('/') }}" class="target-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Target Ink">
            </a>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="/auth/register">
            {!! csrf_field() !!}

            <div class="form-group">
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>
@endsection