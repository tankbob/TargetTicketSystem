<div class="row">
    <div class="col-sm-4 clearfix">
        <h2 class="maintenance-title pull-left">Services</h2> <a href="#" class="form-toggler icon-new-service pull-left" data-uri="/services/create" data-target="#services-form-div" data-selecttarget="#service-customer-select"></a>
    </div>
    <div class="col-sm-8 clearfix text-right client-chooser">
        <label for="service-customer-select" class="hidden-xs hidden-sm">Choose a Client:</label>
    	{!! Form::select('client_id', [ '' => 'Choose a Client...' ] + $clients, request()->input('client_id'), [
        	'id' => 'service-customer-select',
        	'class' => 'form-control ajax-dropdown',
        	'data-target' => '#services-table-div',
        	'data-uri' => '/services/'
        ]) !!}
    </div>
</div>
