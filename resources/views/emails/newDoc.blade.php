@extends('emails.master')

@section('intro')
New Document
@stop

@section('title')
New Document
@stop

@section('content')
<p>URL: <a href="{{ $user->web }}"><strong>{{ $user->web }}</strong></a></p>
<p>Type: Document</p>
<p>Click the link below to download the document:</p>
<p>Direct Link: <a href="{{ url($user->company_slug . '/documents/info?i=' . $user->instant) }}">{{ url($user->company_slug . '/documents/info?i=' . $user->instant) }}</a></p>
@stop