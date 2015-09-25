@extends('includes.layout')

@section('scripts')
	<script type="text/javascript">
		var attachmentCounter = @if(isset($ticket)) 2 @else 1 @endif

		$(function() {
			$("input:file").change(function (){
				addFileInput(this);
			});
		});

		function addFileInput(fileinput){
			alert();
			if($(fileinput).val() && $(fileinput).attr('attachmentID') == attachmentCounter){
				attachmentCounter ++;
				var html = '';
				html += '<div>';
		        	html += '<input attachmentid="'+attachmentCounter+'" name="attachment['+attachmentCounter+']" type="file">';
		        html += '</div>';
		        var $html = $('input:file').change(function(){
		        	addFileInput(this);
		        })
			        $('#attachmentDiv').append($html);
				}
		}
	</script>
@stop

@section('sectionTitle')
	@if(!isset($ticket))
		Create Ticket
	@else
		Edit Ticket
	@endif
@stop

@section('content')
<div class="page-heading text-center">
    <h1>Choose a ticket</h1>
    
    <p>Choose wich kind of request to submit from the following:</p>
  
</div>


<div class="page-content">
    <div class="row">
        <div class="col-xs-12">

        	<form>

			<div>
				{!! Form::radio('type', '1', !isset($ticket) || @$ticket->type == 1) !!} 'Web Amends'
				{!! Form::radio('type', '2', @$ticket->type == 2) !!} 'Add Content'
				{!! Form::radio('type', '3', @$ticket->type == 3) !!} 'Get Quote'
				{!! Form::radio('type', '4', @$ticket->type == 4) !!} 'Ask Question'
			</div>

           	<div>
				{!! Form::text('title', @$ticket->title, ['placeholder' => 'Title']) !!}
	        </div>

           	<div>
				{!! Form::textarea('content', @$ticket->content, ['placeholder' => 'Your Text']) !!}
	        </div>

	        <div id="attachmentDiv">
		        <div>
		        	{!! Form::file('attachment[1]', ['attachmentID' => 1]) !!}
		        </div>
		    </div>

		    </form>

		</div>
    </div>
</div>

@stop