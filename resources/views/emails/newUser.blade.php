@extends('emails.master')

@section('intro')
Maintenance Account Setup
@stop

@section('title')
Maintenance Account Setup
@stop

@section('content')
<p>Dear {{ $user->name }},<br>
A maintenance account has been set up for you.</p>

<p>Here is a direct link to your account, don’t forget to save it on your phone, tablet and desktop (for instructions on how go to <a href="http://targetink.co.uk/maintenace-setup">targetink.co.uk/maintenace-setup</a>)</p>

@if(isset($instant) && $instant)
<p>Direct Link: <a href="{{ url('/?i=' . $instant) }}">{{ url('/?i=' . $instant) }}</a></p>
@else
<p>Direct Link: <a href="{{ url('/') }}">{{ url('/') }}</a></p>
@endif

<p>or go to our login page at: {{ url('auth/login') }} and use the following details:</p>
<p><strong>Email address:</strong> {{ $user->email }}<br>
<strong>Password:</strong> {{ $user->pre_pass }}</p>
@stop