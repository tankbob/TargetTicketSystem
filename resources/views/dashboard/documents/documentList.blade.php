<div class="row">
    <div class="col-sm-4 clearfix">
    	@if($type == 'seo')
    		<h2 class="maintenance-title pull-left">SEO Doc</h2>
    	@else
    		<h2 class="maintenance-title pull-left">Info Doc</h2>
    	@endif

        <a href="#" class="form-toggler icon-new-{{ $type }} pull-left" data-uri="/documents/{{ $type }}/create" data-target="#{{ $type }}-form-div" data-selecttarget="#{{ $type }}-customer-select"></a>
    </div>
    <div class="col-sm-8 clearfix text-right client-chooser">
        <label for="{{ $type }}-customer-select" class="hidden-xs hidden-sm">Choose a Client:</label>
        {!! Form::select('client_id', $clientDropList, request()->segment(3), [
            'id' => $type . '-customer-select',
            'class' => 'form-control ajax-dropdown',
            'data-target' => '#' . $type . '-table-div',
            'data-uri' => '/documents/' . $type . '/'
        ]) !!}
    </div>
</div>
