<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'adverts', 'method' => 'POST', 'id' => 'new-advert-form', 'files' => true, 'class' => 'form-horizontal']) !!}
        @include('includes.fileInputSingle', ['name' => 'image', 'label' => 'Image:'])
        {!! FormHelper::bs('text', 'url', 'URL:', null, null, 'http://www.example.com') !!}
        {!! FormHelper::bs('text', 'name', 'Advert Name:', null, null, 'Example Name') !!}

		<div class="form-group no-mp">
			<div class="col-sm-10 col-sm-offset-2">
				<input type="text" name="client_id" type="text" value="0" class="clientValue fake-hidden">
			</div>
		</div>

    	{!! Form::submit('Add Advert', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
    {!! Form::close() !!}
</div>
