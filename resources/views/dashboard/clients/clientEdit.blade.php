<div clas="row">
    <div class="col-md-10 col-md-offset-1">
        @if(isset($client))
        {!! Form::model($client, ['url' => '/clients/' . $client->id, 'method' => 'PUT', 'id' => 'clientForm', 'class' => 'form-horizontal', 'files' => true]) !!}
        @else
        {!! Form::open(['url' => '/clients', 'method' => 'POST', 'id' => 'clientForm', 'class' => 'form-horizontal', 'files' => true]) !!}
        @endif
            {!! Form::text('client_id', '', ['class' => 'hidden', 'id' => 'client_id']) !!}
            {!! FormHelper::bs('text', 'name', 'Full Name:') !!}
            {!! FormHelper::bs('text', 'email', 'Email Address:') !!}
            {!! FormHelper::bs('text', 'phone', 'Phone Number:') !!}
            {!! FormHelper::bs('password', 'password', 'Password:') !!}
            {!! FormHelper::bs('text', 'company', 'Company Name:') !!}
            {!! FormHelper::bs('text', 'website', 'Website URL:') !!}
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
                        <img src="{{ url('img/logo.png') }}?w=150&amp;h=150&amp;fit=max" alt="" title="">
                    @endif
                </div>
            </div>
            @endif

        	{!! Form::submit('Add / Update Client', ['class' => 'btn btn-info pull-right update-client-btn target-btn']) !!}
        {!! Form::close() !!}
    </div>
</div>
