@if(isset($client))
	{!! Form::model($client, ['url' => '/clients/'.$client->id, 'method' => 'PUT', 'id' => 'clientForm']) !!}
@else
	{!! Form::open(['url' => '/clients', 'method' => 'POST', 'files' => true, 'id' => 'clientForm']) !!}
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
    @if(isset($client))
		{!! Form::submit('Update Client') !!}
    @else
        {!! Form::submit('Add Client') !!}
    @endif
{!!Form::close()!!}