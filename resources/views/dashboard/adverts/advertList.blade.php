<div class="row">
    <div class="col-sm-4 clearfix">
        <h2 class="maintenance-title pull-left">Adverts</h2>
        <a href="#" class="form-toggler icon-new-advert pull-left" data-uri="/adverts/create" data-target="#banner-form-div" data-selecttarget="#banner-customer-select"></a>
    </div>
    <div class="col-sm-8 clearfix text-right client-chooser">
        <label for="banner-customer-select" class="hidden-xs hidden-sm">Choose a Client:</label>
        {!! Form::select('client_id', $clientDropList, request()->input('client_id'), [
        	'id' => 'banner-customer-select',
        	'class' => 'form-control ajax-dropdown',
        	'data-target' => '#banner-table-div',
        	'data-uri' => '/adverts/'
        ]) !!}
    </div>
</div>
