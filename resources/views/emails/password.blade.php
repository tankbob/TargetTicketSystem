@extends('emails.master')

@section('intro')
Password Reset
@stop

@section('title')
Password Reset
@stop

@section('content')
To reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.<br/>
This link will expire in {{ Config::get('auth.reminder.expire', 60) }} minutes.
@stop