<div class="col-md-10 col-md-offset-1">
    {!! Form::open(['url' => 'documents/' . $type, 'method' => 'POST', 'id' => 'new-' . $type . '-form', 'files' => true, 'class' => 'form-horizontal']) !!}
        @include('includes.fileInputSingle', ['name' => 'file', 'label' => 'Document:'])
        {!! FormHelper::bs('text', 'filename', 'Client / Title:') !!}
        
        <div class="form-group no-mp">
            <div class="col-sm-10 col-sm-offset-2">
                <input type="text" name="client_id" type="text" value="{{ request()->segment(3) }}" class="clientValue fake-hidden">
            </div>
        </div>
        
        @if($type == 'seo')
        	{!! Form::submit('Add Report', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
        @else
        	{!! Form::submit('Add Document', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
        @endif 
    {!! Form::close() !!}
</div>
