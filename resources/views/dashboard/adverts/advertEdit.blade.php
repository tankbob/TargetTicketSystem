<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'banners', 'method' => 'POST', 'id' => 'newBannerForm', 'files' => true, 'class' => 'form-horizontal']) !!}

        @include('includes.fileInputSingle', ['name' => 'image', 'label' => 'Image:'])

        {!! FormHelper::bs('text', 'url', 'URL:', null, null, 'http://www.example.com') !!}
        {!! FormHelper::bs('text', 'name', 'Advert Name:', null, null, 'Example Name') !!}
        <input type="hidden" name="client_id" value="0" class="clientValue">
    	{!! Form::submit('Add Advert', ['class' => 'btn btn-info pull-right update-client-btn']) !!}
    {!! Form::close() !!}
</div>
