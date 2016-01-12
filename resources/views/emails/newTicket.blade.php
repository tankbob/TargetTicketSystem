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

@if($instant)
<p>Direct Link: <a href="{{ url($user->company_slug . '/tickets/' . $ticket->id . '?i=' . $user->instant) }}">{{ url($user->company_slug . '/tickets/' . $ticket->id . '?i=' . $user->instant) }}</a></p>
@else
<p>Direct Link: <a href="{{ url($user->company_slug . '/tickets/' . $ticket->id) }}">{{ url($user->company_slug . '/tickets/' . $ticket->id) }}</a></p>
@endif
@stop