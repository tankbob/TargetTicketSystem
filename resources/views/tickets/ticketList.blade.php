@extends('includes.layout')

@section('sectionTitle')
    Your Tickets
@stop

@section('content')
<script>
    @if($archived)
    var $archived = true;
    @else
    var $archived = false;
    @endif

    var $client_id = {{ $client->id }};
</script>

<div class="page-heading text-center">
    <a href="{{ url($client->company_slug . '/tickets/create') }}" class="btn btn-info btn-new-ticket">CREATE A NEW TICKET</a>
</div>

@include('flash::message')

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <div class="border-b ticket-pad">
            	<a href="{{ url($client->company_slug . '/tickets') }}" class="btn-open-tickets @if(!$archived) active @endif "><i></i> View Open Tickets</a>
            	<a href="{{ url($client->company_slug . '/tickets?archived=1') }}" class="btn-archived-tickets @if($archived) active @endif "><i></i> View Archived Tickets</a>
            </div>
        </div>
        <div class="col-xs-12">
            <table class="table text-muted table-muted table-no-borders no-margin">
                <tr>
                    <td width="75">
                        <i class="icon-goto"></i>
                    </td>
                    <td class="td-adjust">
                        Double Click to View Ticket
                    </td>
                    <td class="td-adjust text-right">
                        Click &amp; Drag to Reprioritise Ticket
                    </td>
                    <td width="36">
                        <i class="icon-move icon-muted"></i>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-xs-12">
            <table class="table ticket-table sorted_table" id="ticket_table">
	            <thead>
	            	<tr>
		            	<th width="75"></th>
		            	<th>Ticket Title</th>
		            	<th>Ref No.</th>
		            	<th>Ticket Type</th>
		            	<th>Cost</th>
		            	<th class="text-center">Response</th>
                        @if($archived)
		            	<th class="text-center">Unarchive</th>
                        @else
                        <th class="text-center">Archive</th>
                        @endif
                        @if(auth()->user()->admin)
		       			    <th>Time</th>
		            		<th></th>
		            	@endif
		            	<th width="36"></th>
		            </tr>
	            </thead>
	            <tbody>
	            	@foreach($tickets as $ticket)
	            		<tr id="{{ $ticket->id }}">
	            			<td><a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}" class="show-on-hover icon-goto"></a></td>
	            			<td class="td-adjust">{{ $ticket->title }}</td>
	            			<td class="td-adjust">{{ $ticket->getRef() }}</td>
	            			<td class="td-adjust">
	            				@if($ticket->type == 1)
	            					Web Amends
	            				@elseif($ticket->type == 2)
	            					Add Content
	            				@elseif($ticket->type == 3)
	            					Get Quote
	            				@elseif($ticket->type == 4)
	            					Ask Question
	            				@endif
	            			</td>
	            			<td class="td-adjust">@if($ticket->cost) &pound;{{ $ticket->cost }} @else N/A @endif</td>
	            			<td class="text-center">
                                @if(@$ticket->responses->last()->admin)
                                <i class="icon-response"></i>
                                @endif
                            </td>
	            			@if($archived)
            				<td class="text-center">
                                <a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}/unarchive" class="btn-unarchive"></a>
                            </td>
	            			@else
            				<td class="text-center">
                                <a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}/archive" class="btn-archive"></a>
                            </td>
	            			@endif
                            @if(auth()->user()->admin)
		       				    <th>{{$ticket->totalTime()}}</th>
			            		<td>
			            			{!! Form::open(['url' => '/'.$client->company_slug.'/tickets/'.$ticket->id, 'method' => 'DELETE']) !!}
			            				{!! Form::submit('Delete') !!}
			            			{!! Form::close() !!}
			            		</td>
			            	@endif
	            			<td><i class="show-on-hover icon-move"></i></td>
	            		</tr>
	            	@endforeach
	            </tbody>
            </table>
        </div>
    </div>
</div>
@stop
