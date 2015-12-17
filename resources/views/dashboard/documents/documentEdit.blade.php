<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'documents/' . $type, 'method' => 'POST', 'id' => 'new-' . $type . '-form', 'files' => true, 'class' => 'form-horizontal']) !!}
        {!! FormHelper::bs('file', 'file', 'Document:') !!}
        {!! FormHelper::bs('text', 'filename', 'Client / Title:') !!}
        {!! Form::submit('Add Report', ['class' => 'btn btn-info pull-right update-client-btn']) !!}
    {!! Form::close() !!}
</div>
