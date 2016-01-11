@extends('emails.master')

@section('intro')
@if($ticket->priority) PRIORITY @endif Support Request: {{ $ticket->getRef() }}
@stop

@section('title')
@if($ticket->priority) PRIORITY @endif Support Request: {{ $ticket->getRef() }}
@stop

@section('content')
<p>URL: <a href="{{ $user->web }}"><strong>{{ $user->web }}</strong></a></p>
<p>Ref Number: <strong>{{ $ticket->getRef() }}</strong></p>
<p>Ticket type: <strong>{{ $ticket->getType() }}</strong></p>
<p>Priority: <strong>{{ $ticket->getPriority() }}</strong></p>
<p>Title: <strong>{{ $ticket->title }}</strong></p>
<p>{{ $response->content }}</p>
<p>Direct Link: <a href="{{ url('instant/index/123465') }}">{{ url('instant/index/123465') }}</a></p>
@stop