@extends('includes.layout')

@section('sectionTitle')
	Open Ticket
@stop

@section('scripts')
	
	<script type="text/javascript">
		var attachmentCounter = 1;

		$(function() {
			$("#attachmentDiv").on('change', '.fileInput', function (){
				addFileInput(this);
			});
		});

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

@section('content')
<div class="page-heading text-center">
    <h1>Ticket Details</h1>  
</div>


<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
           
           <div class="form-group">
           		{!! Form::label('title', 'Ticket Title', ['class' => 'col-xs-4 form-label']) !!}
           		<div class="col-xs-8">
           			{!! Form::text('title', $ticket->title, ['class' => 'form-control', 'disabled']) !!}
           		</div>
            </div>

            <div class="form-group">
           		{!! Form::label('ref_no', 'Reference No.', ['class' => 'col-xs-4 form-label']) !!}
           		<div class="col-xs-8">
           			{!! Form::text('ref_no', $ticket->ref_no, ['class' => 'form-control', 'disabled']) !!}
           		</div>
            </div>

           	@if(\Auth::user()->admin)
           		{!! Form::model($ticket, ['url' => '/tickets/'.$ticket->id, 'method' => 'PUT', 'files' => true]) !!}
           	@endif

            <div class="form-group">
           		{!! Form::label('type', 'Ticket Type', ['class' => 'col-xs-4 form-label']) !!}
           		<div class="col-xs-8">
           			@if(\Auth::user()->admin)
           				{!! Form::select('type', [1 => "Web Amends", 2 => "Add Content", 3 => "Get Quote", 4 => "Ask Question"], $ticket->type, ['class' => 'form-control']) !!}
           			@else
	           			{!! Form::select('type', [1 => "Web Amends", 2 => "Add Content", 3 => "Get Quote", 4 => "Ask Question"], $ticket->type, ['class' => 'form-control', 'disabled']) !!}
	           		@endif 
           		</div>
            </div>
           
            @if(\Auth::user()->admin)
            	{!! Form::submit() !!}
            	{!! Form::close() !!}
            @endif


            @foreach($ticket->responses as $response)

            	<div class="panel @if($response->admin) admin_response @else client_response @endif">
					<div class="panel-heading">
					@if($response->admin) Support: Response @else Client: Response @endif
					Date: {{date('d/m/y', strtotime($response->created_at))}}
					Time: {{date('H:i', strtotime($response->created_at))}}
					@if($response->admin) ({{date('H:i', strtotime($response->working_time))}}) @endif
					</div>
					<div class="panel-body">
						{{$response->content}}
						@if($response->cost)
							<div class="response_data">Cost: {{$response->cost}}</div>
						@endif
						@if($response->article_title)
							<div class="response_data">Article Title: {{$response->article_title}}</div>
						@endif
						@if($response->categories)
							<div class="response_data">Categories: {{$response->categories}}</div>
						@endif
						@if($response->published_at != '0000-00-00')
							<div class="response_data">Published At: {{date('d/m/y', strtotime($response->published_at))}}</div>
						@endif
						@if($response->author)
							<div class="response_data">Author: {{$response->author}}</div>
						@endif
						@if($response->schedule)
							<div class="response_data">Schedule: {{$response->schedule}}</div>
						@endif

						@foreach($response->attachments as $attachment)
							@if($attachment->type == 'I')
								<img src="/files/tickets/{{$attachment->filename}}" alt="{{$attachment->original_filename}}">
							@else
								<a href="/files/tickets/{{$attachment->filename}}" target="#blank">DOWNLOAD ICON</a>
							@endif
						@endforeach
					</div>
            	</div>

            @endforeach



            {!! Form::open(['url' => '/ticket/'.$ticket->id.'/addresponse', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal object-editor']) !!}

            	<div @if($errors->has('content')) has-error dark @endif>
	           		@if($errors->has('content'))
	           			<span class="alert-danger"> {{ $errors->first('content') }} </span>
	           		@endif
					{!! Form::textarea('content', '', ['placeholder' => 'Enter your Response...']) !!}
		        </div>

            	<div id="attachmentDiv">
			        <div>
			        	{!! Form::file('attachment-1', ['attachmentID' => 1, 'class' => 'fileInput']) !!}
			        </div>
			    </div>

		    	<input type="hidden" name="attachment_count" id="attachment_count" value="1">

			    {!! Form::submit('Respond') !!}

            {!! Form::close() !!}

		</div>
    </div>
</div>

@stop