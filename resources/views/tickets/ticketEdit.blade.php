@extends('includes.layout')

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
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12">
			{!! Form::open(['url' => $company_slug.'/tickets', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal object-editor']) !!}

			<div class="text-center">
				{!! Form::radio('type', '1', !isset($ticket) || @$ticket->type == 1, ['class' => 'type', 'id' => 'web-amends']) !!} <label for="web-amends" class="btn-web-amends"></label>
				{!! Form::radio('type', '2', @$ticket->type == 2, ['class' => 'type', 'id' => 'add-content']) !!} <label for="add-content" class="btn-add-content"></label>
				{!! Form::radio('type', '3', @$ticket->type == 3, ['class' => 'type', 'id' => 'get-quote']) !!} <label for="get-quote" class="btn-get-quote"></label>
				{!! Form::radio('type', '4', @$ticket->type == 4, ['class' => 'type', 'id' => 'ask-question']) !!} <label for="ask-question" class="btn-ask-question"></label>
			</div>

			<div class="ticket-form">

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

		        <!-- Only Retrieve one file error if there is more than one-->
		        @if(old('attachment_count'))
		        	@for($i = 1; $i <= old('attachment_count'); $i ++)
		        		@if($errors->has('attachment-'.$i))
		        			<span class="alert-danger"> {{ $errors->first('attachment-'.$i) }} </span>
		        			<?php $i = old('attachment_count'); ?>
		        		@endif
		        	@endfor
				@endif

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
			    	{!! Form::submit('submit', ['class' => 'btn btn-success']) !!}
			    </div>

			    {!! Form::checkbox('priority', '1', @$ticket->priority) !!}
			    {!! Form::label('priority', 'Priority Request? All priority request will be invoiced! <br> Clients with a maintenance contract will only be invoiced should the time exceed your monthly allowance. PLEASE NOTE you will not be informed if the time runs over your allowance and you will be charged by the hour until the job is completed. If you have any questions or querties please get in touch on 01892 800 400') !!}
			</div>
		    {!! Form::close() !!}
		</div>
    </div>
</div>
@stop
