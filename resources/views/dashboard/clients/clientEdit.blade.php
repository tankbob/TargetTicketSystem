<div clas="row">
    <div class="col-md-10 col-md-offset-1">
        @if(isset($client))
        {!! Form::model($client, ['url' => '/clients/' . $client->id, 'method' => 'PUT', 'id' => 'clientForm', 'class' => 'form-horizontal']) !!}
        @else
        {!! Form::open(['url' => '/clients', 'method' => 'POST', 'id' => 'clientForm', 'class' => 'form-horizontal']) !!}
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
        	{!! Form::submit('Add / Update Client', ['class' => 'btn btn-info pull-right update-client-btn']) !!}
        {!! Form::close() !!}
    </div>
</div>
