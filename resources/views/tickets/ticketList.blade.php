@extends('includes.layout')

@section('sectionTitle')
    Your Tickets
@stop


@section('scripts')

	
	<script src="/js/jquery-sortable.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			
			$('.sorted_table').sortable({
				containerSelector: 'table',
				handle: 'i.icon-move',
				itemPath: '> tbody',
				itemSelector: 'tr',
				placeholder: '<tr class="placeholder"/>',
				onDrop: function ($item, container, _super, event) {

					var new_order = [];
					$("#ticket_table tbody").find("tr").each(function(){ new_order.push(this.id); });

					$.ajax({
		                type: "POST",
		                url: '/api/ticketsort',
		                data: {
		                	'user_id': {{$client->id}},
		                	'archived': {{$archived}},
		                	'new_order': new_order
		                },
					success: function(response) {
		                    
		                }
		            });
					$item.removeClass(container.group.options.draggedClass).removeAttr("style")
					$("body").removeClass(container.group.options.bodyClass)
				}
			});
			
		});
</script>

@stop

@section('content')
<div class="page-heading text-center">
    <a href="/{{$client->company_slug}}/tickets/create">CREATE A NEW TICKET</a>
</div>

@include('flash::message')

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        	<a href="/{{$client->company_slug}}/tickets" @if(!$archived) class="active" @endif>View Open Tickets</a>

        	<a href="/{{$client->company_slug}}/tickets?archived=1" @if($archived) class="active" @endif>View Archived Tickets</a>



            <table class="table table-striped table-bordered sorted_table" id="ticket_table">
	            <thead>
	            	<tr>
		            	<th>GOTO ICON</th>
		            	<th>Ticket Title</th>
		            	<th>Ref No.</th>
		            	<th>Ticket Type</th>
		            	<th>Cost</th>
		            	<th>Response</th>
		            	<th>Archive</th>
		       			<th>Time</th>
		            	@if(auth()->user()->admin)
		            		<th></th>
		            	@endif
		            	<th>MOVE ICON</th>
		            </tr>
	            </thead>
	            <tbody>
	            	@foreach($tickets as $ticket)
	            		<tr id="{{$ticket->id}}">
	            			<td><a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}">icon</a></td>
	            			<td>{{$ticket->title}}</td>
	            			<td>{{$ticket->id}}</td>
	            			<td>
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
	            			<td>@if($ticket->cost) &pound;{{$ticket->cost}} @else N/A @endif</td>
	            			<td>@if(@$ticket->responses->last()->admin) ICON @endif</td></td>
	            			@if($archived)
	            				<td><a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}/unarchive">UNARCHIVE ICON</a></td>
	            			@else
	            				<td><a href="/{{$client->company_slug}}/tickets/{{$ticket->id}}/archive">ARCHIVE ICON</a></td>
	            			@endif
		       				<th>{{$ticket->totalTime()}}</th>
	            			@if(auth()->user()->admin)
			            		<td>
			            			{!! Form::open(['url' => '/'.$client->company_slug.'/tickets/'.$ticket->id, 'method' => 'DELETE']) !!}
			            				{!! Form::submit('Delete') !!}
			            			{!! Form::close() !!}
			            		</td>
			            	@endif
	            			<td><i class="icon-move">aa</i></td>
	            		</tr>
	            	@endforeach            	
	            </tbody>
            </table>
        </div>
    </div>
</div>



@stop