<div clas="row">
    <div class="col-md-10 col-md-offset-1">
        @if(isset($client))
        {!! Form::model($client, ['route' => ['clients.update', $client->id], 'method' => 'patch', 'id' => 'update-client-form', 'class' => 'form-horizontal', 'files' => true]) !!}
        @else
        {!! Form::open(['route' => ['clients.store'], 'id' => 'new-client-form', 'class' => 'form-horizontal', 'files' => true]) !!}
        @endif
            {!! Form::hidden('client_id', $client_id, ['id' => 'client_id']) !!}
            {!! FormHelper::bs('text', 'name', 'Full Name:') !!}
            {!! FormHelper::bs('text', 'email', 'Email Address:') !!}
            {!! FormHelper::bs('text', 'second_email', 'Secondary Email Address:') !!}
            {!! FormHelper::bs('text', 'phone', 'Phone Number:') !!}
            {!! FormHelper::bs('text', 'password', 'Password:') !!}
            {!! FormHelper::bs('text', 'company', 'Company Name:') !!}
            {!! FormHelper::bs('text', 'web', 'Website URL:') !!}
            {!! FormHelper::bs('text', 'type', 'Account Type:') !!}
            {!! FormHelper::bs('text', 'start_date', 'Account Start Date:') !!}
            @include('includes.fileInputSingle', ['name' => 'company_logo', 'label' => 'Company Logo:'])

            @if(isset($client))
            <div class="form-group">
                <label class="col-sm-2 control-label">Current Logo:</label>
                <div class="col-sm-10">
                    @if(isset($client->company_logo) && $client->company_logo)
                        <img src="{{ url('img/' . $client->company_logo) }}?w=150&amp;h=150&amp;fit=max" alt="" title="">
                    @else
                        <img src="{{ url('images/logo.svg') }}" alt="" title="" style="max-width:150px;">
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label for="web" class="col-sm-2 control-label">Instant Link:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" disabled value="{{ url('?i=' . $client->instant) }}">
                </div>
            </div>
            @endif

        	{!! Form::submit('Add / Update Client', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
        {!! Form::close() !!}
    </div>
</div>
