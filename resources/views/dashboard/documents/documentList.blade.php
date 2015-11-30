<div class="col-sm-12">
    <div class="col-sm-6">
    	@if($type == 'seo')
    		SEO Doc <a href="#" class="seo-form-toggler" clientId="0">NEW SEO ICON</a>
    	@else
    		info Doc <a href="#" class="info-form-toggler" clientId="0">NEW INFO ICON</a>
    	@endif
    </div>
    <div class="col-sm-6">
        @if($type == 'seo')
    	   {!! Form::select('client_id', [ '' => '' ] + $clients, '', ['id' => 'seo-customer-select']) !!}
        @else
           {!! Form::select('client_id', [ '' => '' ] + $clients, '', ['id' => 'info-customer-select']) !!}
        @endif
    </div>
</div>
