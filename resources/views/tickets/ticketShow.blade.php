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

			$('.hourInput').mask("99:99",{placeholder:"00:00"});
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

@include('flash::message')

<div class="page-content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1 form-horizontal">
			<div class="form-group">
				{!! Form::label('title', 'Ticket Title', ['class' => 'col-xs-4 form-label']) !!}
				<div class="col-xs-8">
					{!! Form::text('title', $ticket->title, ['class' => 'form-control', 'disabled']) !!}
				</div>
			</div>

            <div class="form-group">
           		{!! Form::label('ref_no', 'Reference No.', ['class' => 'col-xs-4 form-label']) !!}
           		<div class="col-xs-8">
           			{!! Form::text('ref_no', $ticket->id, ['class' => 'form-control', 'disabled']) !!}
           		</div>
            </div>

			@if(auth()->user()->admin)
           		{!! Form::model($ticket, ['url' => '/' . $company_slug . '/tickets/' . $ticket->id, 'method' => 'PUT']) !!}
           	@endif

            <div class="form-group">
           		{!! Form::label('type', 'Ticket Type', ['class' => 'col-xs-4 form-label']) !!}
           		<div class="col-xs-8">
           			@if(auth()->user()->admin)
           				{!! Form::select('type', [1 => "Web Amends", 2 => "Add Content", 3 => "Get Quote", 4 => "Ask Question"], $ticket->type, ['class' => 'form-control']) !!}
           			@else
	           			{!! Form::select('type', [1 => "Web Amends", 2 => "Add Content", 3 => "Get Quote", 4 => "Ask Question"], $ticket->type, ['class' => 'form-control', 'disabled']) !!}
	           		@endif
           		</div>
            </div>

            <div class="form-group">
           		{!! Form::label('total_working_time', 'Time', ['class' => 'col-xs-4 form-label']) !!}
           		<div class="col-xs-8">
           			{!! Form::text('total_working_time', $ticket->totalTime(), ['class' => 'form-control', 'disabled']) !!}
           		</div>
            </div>

            @if(auth()->user()->admin)
          		<div class="form-group">
	           		{!! Form::label('cost', 'Cost (&pound;)', ['class' => 'col-xs-4 form-label']) !!}
	           		<div class="col-xs-8">
	           			{!! Form::text('cost', $ticket->cost, ['class' => 'form-control']) !!}
	           		</div>
	            </div>
           	@elseif($ticket->cost)
           		<div class="form-group">
	           		{!! Form::label('cost', 'Cost (&pound;)', ['class' => 'col-xs-4 form-label']) !!}
	           		<div class="col-xs-8">
	           			{!! Form::text('cost', $ticket->cost, ['class' => 'form-control', 'disabled']) !!}
	           		</div>
	            </div>
           	@endif

            @if(auth()->user()->admin)
            	{!! Form::submit() !!}
            	{!! Form::close() !!}
            @endif
		</div>
		<div class="col-md-12">
			<hr>
		</div>
		<div class="col-md-10 col-md-offset-1">
			@if(count($ticket->responses))
	            @foreach($ticket->responses as $response)
	            	<div class="panel panel-default @if($response->admin) admin_response @else client_response @endif">
						<div class="panel-heading text-center">
							<span>@if($response->admin) Support: Response @else Client: Response @endif</span>
							<span>Date: {{ date('d/m/y', strtotime($response->created_at)) }}</span>
							<span>Time: {{ date('H:i', strtotime($response->created_at)) }}</span>
							@if($response->admin)
								@if(auth()->user()->admin)
									{!! Form::open(['url' => $company_slug . '/tickets/' . $ticket->id . '/' . $response->id . '/edittime', 'method' => 'POST', 'class' => 'form-horizontal hidden object-editor']) !!}
											{!! Form::text('working_time', $response->formatWorkingTime(), ['class' => 'hourInput']) !!}
										{!! Form::submit('save') !!}
									{!! Form::close() !!}
								@else
									({{ $response->formatWorkingTime() }})
								@endif
							@endif
						</div>
						<div class="panel-body">
							<div>{!! nl2br($response->content, false) !!}</div>

							@if($response->article_title)
								<div class="response_data">Article Title: {{ $response->article_title }}</div>
							@endif
							@if($response->categories)
								<div class="response_data">Categories: {{ $response->categories }}</div>
							@endif
							@if($response->published_at != '0000-00-00')
								<div class="response_data">Published At: {{ date('d/m/y', strtotime($response->published_at)) }}</div>
							@endif
							@if($response->author)
								<div class="response_data">Author: {{ $response->author }}</div>
							@endif
							@if($response->schedule)
								<div class="response_data">Schedule: {{ $response->schedule }}</div>
							@endif

							@foreach($response->attachments as $attachment)
							<div class="attachment">
								@if($attachment->type == 'I')
									<img src="/img/{{ $attachment->filename }}?w=510&amp;fit=max" alt="{{ $attachment->original_filename }}">
								@else
									<p class="document">{{ $attachment->getFilename() }}</p>
								@endif
								<a href="{{ config('app.asset_url') }}{{ $attachment->filename }}" target="_blank" class="icon-download"></a>
							</div>
							@endforeach
						</div>
	            	</div>
	            @endforeach
			@else
				<div class="alert alert-info">There are no responses yet</div>
			@endif

            {!! Form::open(['url' => $company_slug . '/tickets/' . $ticket->id . '/addresponse', 'method' => 'POST', 'files' => true, 'class' => 'object-editor']) !!}

            	<div class="form-group @if($errors->has('content')) has-error dark @endif ">
	           		@if($errors->has('content'))
	           			<span class="alert-danger"> {{ $errors->first('content') }} </span>
	           		@endif
					{!! Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Enter your Response...']) !!}
		        </div>

				@include('includes.fileInput')

		    	@if(auth()->user()->admin)
				<div class="form-group">
		    		{!! Form::text('working_time', '', ['placeholder' => '00:00', 'class' => 'hourInput form-control']) !!}
				</div>
		    	@endif

				<div class="text-center">
				    {!! Form::submit('Respond', ['class' => 'btn btn-success btn-ticket-respond']) !!}
				</div>
            {!! Form::close() !!}
		</div>
    </div>
</div>

@stop
