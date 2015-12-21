<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'services', 'method' => 'POST', 'id' => 'newServiceForm', 'files' => true, 'class' => 'form-horizontal']) !!}
        @include('includes.fileInputSingle', ['name' => 'icon', 'label' => 'Icon Normal: 3mb max 146 x 146'])
        @include('includes.fileInputSingle', ['name' => 'icon_rollover', 'label' => 'Icon Rollover: 3mb max 146 x 146'])
        {!! FormHelper::bs('text', 'heading', 'Heading:', null, null) !!}
        {!! FormHelper::bs('text', 'link', 'Icon Link:', null, null, 'http://www.example.com') !!}
        {!! FormHelper::bs('textarea', 'text', 'Text:') !!}
        {!! Form::submit('Add Service', ['class' => 'btn btn-info pull-right update-client-btn']) !!}
    {!! Form::close() !!}
</div>
