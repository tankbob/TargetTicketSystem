@extends('includes.layout')
<!-- I THINK THAT VIEW IS NEVER GOING TO BE ACCESSED TO EDIT BUT I JUST ADD THE CONDITIONS JUST IN CASE -->
@section('scripts')
	<script type="text/javascript">
		var attachmentCounter = 1;

		$(function() {
			$("#attachmentDiv").on('change', '.fileInput', function (){
				addFileInput(this);
			});

			$('.type').on('change', function(){
				toggleFormFields($('.type:checked').val());
			});

			toggleFormFields($('.type:checked').val());

			$('.dateInput').mask("99/99/9999",{placeholder:"DD/MM/YYYY"});
		});

		function toggleFormFields(typeValue){
			switch(typeValue) {
				case '1':
					$('#publishedAtDiv').addClass('hidden');
					$('#authorDiv').addClass('hidden');
					$('#categoriesDiv').addClass('hidden');
					$('#artitcleTitleDiv').addClass('hidden');
					$('#scheduleDiv').addClass('hidden');
					$('#content').attr('placeholder', 'Your Text');
					break;
				case '2':
					$('#publishedAtDiv').removeClass('hidden');
					$('#authorDiv').removeClass('hidden');
					$('#categoriesDiv').removeClass('hidden');
					$('#artitcleTitleDiv').removeClass('hidden');
					$('#scheduleDiv').addClass('hidden');
					$('#content').attr('placeholder', 'Notes (For content ideally please submit a word or text doc. below)');
					break;
				case '3':
					$('#publishedAtDiv').addClass('hidden');
					$('#authorDiv').addClass('hidden');
					$('#categoriesDiv').addClass('hidden');
					$('#artitcleTitleDiv').addClass('hidden');
					$('#scheduleDiv').removeClass('hidden');
					$('#content').attr('placeholder', 'Your Text');
					break;
				case '4':
					$('#publishedAtDiv').addClass('hidden');
					$('#authorDiv').addClass('hidden');
					$('#categoriesDiv').addClass('hidden');
					$('#artitcleTitleDiv').addClass('hidden');
					$('#scheduleDiv').addClass('hidden');
					$('#content').attr('placeholder', 'How can we help...');
					break;
				default:
					break;
			}
		}

		function addFileInput(fileinput){
			if($(fileinput).val() && $(fileinput).attr('attachmentID') == attachmentCounter){
				attachmentCounter ++;
				var html = '';
				html += '<div>';
		        	html += '<input class="fileInput" attachmentid="'+attachmentCounter+'" name="attachment-'+attachmentCounter+'" type="file">';
		        html += '</div>';
		        $('#attachmentDiv').append(html);
		        $('#attachment_count').val(attachmentCounter);
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

			{!! Form::open(['url' => $company_slug.'/tickets', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal object-editor']) !!}
		
			<div>
				{!! Form::radio('type', '1', !isset($ticket) || @$ticket->type == 1, ['class' => 'type']) !!} 'Web Amends'
				{!! Form::radio('type', '2', @$ticket->type == 2, ['class' => 'type']) !!} 'Add Content'
				{!! Form::radio('type', '3', @$ticket->type == 3, ['class' => 'type']) !!} 'Get Quote'
				{!! Form::radio('type', '4', @$ticket->type == 4, ['class' => 'type']) !!} 'Ask Question'
			</div>

           	<div @if($errors->has('title')) has-error dark @endif>
           		@if($errors->has('title'))
           			 <span class="alert-danger"> {{ $errors->first('title') }} </span> 
           		@endif
				{!! Form::text('title', @$ticket->title, ['placeholder' => 'Ticket Title']) !!}
	        </div>

	        <div id="scheduleDiv">
	        	{!! Form::text('schedule', @$ticket->schedule, ['placeholder' => 'What\'s your schedule']) !!}
	        </div>

           	<div @if($errors->has('content')) has-error dark @endif>
           		@if($errors->has('content'))
           			<span class="alert-danger"> {{ $errors->first('content') }} </span>
           		@endif
				{!! Form::textarea('content', @$ticket->content, ['placeholder' => 'Your Text', 'id' => 'content']) !!}
	        </div>


	        <div id="attachmentDiv">
		        <div>
		        	{!! Form::file("attachment-1", ['attachmentID' => 1, 'class' => 'fileInput']) !!}
		        </div>
		    </div>

		    <input type="hidden" name="attachment_count" id="attachment_count" value="1">

	        <div id="publishedAtDiv">
	        	<div>
	        		@if(@$ticket->published_at)
	        			{!! Form::text('published_at', date('d m Y', strtotime(@$ticket->published_at)), ['placeholder' => 'Date To Be Published (Please use format: DD/MM/YYYY)']) !!}
	        		@else
	        			{!! Form::text('published_at', '', ['placeholder' => 'Date To Be Published (Please use format: DD/MM/YYYY)', 'class' => 'dateInput']) !!}
	        		@endif
	        	</div>
	        </div>

	        <div id="authorDiv">
	        	<div>
	        		{!! Form::text('author', @$ticket->author, ['placeholder' => 'Author, Google Plus Account if required']) !!}
	        	</div>
	        </div>

	        <div id="categoriesDiv">
	        	<div>
	        		{!! Form::text('categories', @$ticket->categories, ['placeholder' => 'Categories']) !!}
	        	</div>
	        </div>

	        <div id="artitcleTitleDiv">
	        	<div>
	        		{!! Form::text('article_title', @$ticket->article_title, ['placeholder' => 'Article Or Event Title']) !!}
	        	</div>
	        </div>

		    <div>
		    	{!! Form::submit('submit') !!}
		    </div>

		    {!! Form::checkbox('priority', '1', @$ticket->priority) !!}
		    {!! Form::label('priority', 'Priority Request? All priority request will be invoiced! <br> Clients with a maintenance contract will only be invoiced should the time exceed your monthly allowance. PLEASE NOTE you will not be informed if the time runs over your allowance and you will be charged by the hour until the job is completed. If you have any questions or querties please get in touch on 01892 800 400') !!}

		    {!! Form::close() !!}

		</div>
    </div>
</div>

@stop