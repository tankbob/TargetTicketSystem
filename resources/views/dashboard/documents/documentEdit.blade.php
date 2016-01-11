<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'documents/' . $type, 'method' => 'POST', 'id' => 'new-' . $type . '-form', 'files' => true, 'class' => 'form-horizontal']) !!}
        @include('includes.fileInputSingle', ['name' => 'file', 'label' => 'Document:'])
        {!! FormHelper::bs('text', 'filename', 'Client / Title:') !!}
        <input type="hidden" name="client_id" value="0" class="clientValue">
        @if($type == 'seo')
        	{!! Form::submit('Add Report', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
        @else
        	{!! Form::submit('Add Document', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
        @endif 
    {!! Form::close() !!}
</div>
