<div class="row">
    <div class="col-sm-6">
        <h2 class="maintenance-title pull-left">Adverts</h2> <a href="#" class="bannerFormToggler icon-new-advert pull-left" clientId="0"></a>
    </div>
    <div class="col-sm-6 text-right client-chooser">
        <label for="banner-customer-select" class="hidden-xs">Choose a Client:</label>
        {!! Form::select('client_id', [ '' => 'Choose a Client...' ] + $clients, request()->input('client_id'), ['id' => 'banner-customer-select']) !!}
    </div>
</div>
