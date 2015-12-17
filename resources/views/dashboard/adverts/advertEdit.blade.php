<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'banners', 'method' => 'POST', 'id' => 'newBannerForm', 'files' => true, 'class' => 'form-horizontal']) !!}
        <div class="form-group">
        	<label for="image" class="col-sm-2 control-label">Image:</label>
        	<div class="col-sm-10">
        		<input class="form-control" id="image" name="image" type="file">
        	</div>
        </div>
        {!! FormHelper::bs('text', 'url', 'URL:', null, null, 'http://www.example.com') !!}
        {!! FormHelper::bs('text', 'name', 'Advert Name:', null, null, 'Example Name') !!}
        <input type="hidden" name="client_id" value="0" class="clientValue">
    	{!! Form::submit('Add Advert', ['class' => 'btn btn-info pull-right update-client-btn']) !!}
    {!! Form::close() !!}
</div>
