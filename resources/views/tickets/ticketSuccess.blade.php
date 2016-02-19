@extends('includes.layout')

@section('sectionTitle')
	CREATED TICKET
@stop

@section('content')
<div class="page-heading text-center">
	<h1>SUBMISSION SUCCESS</h1>

	@if(auth()->user()->admin)
		<p>Your ticket has been submitted for the user. Go back to:</p>
	@else
		<p>Thank you for your request our team are on the case. Go back to:</p>
	@endif

	<a href="{{ url('/') }}" class="your-services-icon"></a>
	<a href="{{ url($company_slug . '/tickets') }}" class="your-tickets-icon"></a> 
</div>
@stop
