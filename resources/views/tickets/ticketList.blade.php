@extends('includes.layout')

@section('sectionTitle')
    Your Tickets
@stop


@section('scripts')

	
	<script src="js/jquery-sortable.js"></script>

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
		                	'user_id': {{$client_id}},
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
    <a href="/tickets/create">CREATE A NEW TICKET</a>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        	<a href="/tickets" @if(!$archived) class="active" @endif>View Open Tickets</a>

        	<a href="/tickets?archived=1" @if($archived) class="active" @endif>View Archived Tickets</a>



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
		            	<th>MOVE ICON</th>
		            </tr>
	            </thead>
	            <tbody>
	            	@foreach($tickets as $ticket)
	            		<tr id="{{$ticket->id}}">
	            			<td><a href="/tickets/{{$ticket->id}}">icon</a></td>
	            			<td>{{$ticket->title}}</td>
	            			<td>{{$ticket->ref_no}}</td>
	            			<td>{{$ticket->type}}</td>
	            			<td>{{$ticket->cost}}</td>
	            			<td>@if(true) ICON @endif</td></td>
	            			@if($archived)
	            				<td><a href="/tickets/{{$ticket->id}}/unarchive">UNARCHIVE ICON</a></td>
	            			@else
	            				<td><a href="/tickets/{{$ticket->id}}/archive">ARCHIVE ICON</a></td>
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