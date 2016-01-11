<div class="row">
    <div class="col-sm-4 clearfix">
    	@if($type == 'seo')
    		<h2 class="maintenance-title pull-left">SEO Doc</h2> <a href="#" class="seo-form-toggler icon-new-seo pull-left" clientId="0"></a>
    	@else
    		<h2 class="maintenance-title pull-left">Info Doc</h2> <a href="#" class="info-form-toggler icon-new-info pull-left" clientId="0"></a>
    	@endif
    </div>
    <div class="col-sm-8 clearfix text-right client-chooser">
        <label for="{{ $type }}-customer-select" class="hidden-xs hidden-sm">Choose a Client:</label>
    	{!! Form::select('client_id', [ '' => 'Choose a Client...' ] + $clients, request()->input('client_id'), ['id' => $type . '-customer-select', 'class' => 'form-control']) !!}
    </div>
</div>
