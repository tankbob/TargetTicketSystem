<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'services', 'method' => 'POST', 'id' => 'new-service-form', 'files' => true, 'class' => 'form-horizontal']) !!}
        @include('includes.fileInputSingle', ['name' => 'icon', 'label' => 'Icon Normal: 3mb max 146 x 146'])
        @include('includes.fileInputSingle', ['name' => 'icon_rollover', 'label' => 'Icon Rollover: 3mb max 146 x 146'])
        {!! FormHelper::bs('text', 'heading', 'Heading:', null, null) !!}
        {!! FormHelper::bs('text', 'link', 'Icon Link:', null, null, 'http://www.example.com') !!}
        {!! FormHelper::bs('textarea', 'text', 'Text:') !!}
        
        <div class="form-group no-mp">
			<div class="col-sm-10 col-sm-offset-2">
				<input type="text" name="client_id" type="text" value="{{ request()->segment(2) }}" class="clientValue fake-hidden">
			</div>
		</div>
		
        {!! Form::submit('Add Service', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
    {!! Form::close() !!}
</div>
