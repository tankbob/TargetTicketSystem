<div class="col-sm-12">
    <div class="col-sm-6">
    	@if($type == 'seo')
    		<h2 class="maintenance-title pull-left">SEO Doc</h2> <a href="#" class="seo-form-toggler icon-new-seo pull-left" clientId="0"></a>
    	@else
    		<h2 class="maintenance-title pull-left">Info Doc</h2> <a href="#" class="info-form-toggler icon-new-info pull-left" clientId="0"></a>
    	@endif
    </div>
    <div class="col-sm-6 text-right client-chooser">
        <label for="{{ $type }}-customer-select">Choose a Client:</label>
    	{!! Form::select('client_id', [ '' => '' ] + $clients, '', ['id' => $type . '-customer-select']) !!}
    </div>
</div>
