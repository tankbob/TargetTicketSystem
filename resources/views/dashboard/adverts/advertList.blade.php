<div class="col-sm-12">
    <div class="col-sm-6">
    	Adverts <a href="#" class="bannerFormToggler" clientId="0">NEW ADVERT ICON</a>
    </div>
    <div class="col-sm-6">
    	{!! Form::select('client_id', [ '' => '' ] + $clients, '', ['id' => 'banner-customer-select']) !!}
    </div>
</div>
