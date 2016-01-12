@extends('emails.master')

@section('intro')
New SEO Document
@stop

@section('title')
New SEO Document
@stop

@section('content')
<p>URL: <a href="{{ $user->web }}"><strong>{{ $user->web }}</strong></a></p>
<p>Type: Review document</p>
<p>Click the link below to download the latests stats and update:</p>
<p>Direct Link: <a href="{{ url($user->company_slug . '/documents/seo?i=' . $user->instant) }}">{{ url($user->company_slug . '/documents/seo?i=' . $user->instant) }}</a></p>
@stop