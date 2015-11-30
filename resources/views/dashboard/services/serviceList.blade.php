<div class="col-sm-12">
    <div class="col-sm-6">
    	Services <a href="#" class="services-form-toggler" clientId="0">NEW SERVICE ICON</a>
    </div>
    <div class="col-sm-6">
    	{!! Form::select('client_id', [ '' => '' ] + $clients, '', ['id' => 'service-customer-select']) !!}
    </div>
</div>
