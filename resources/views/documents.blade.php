@extends('includes.layout')

@section('sectionTitle')
	@if($type == 'seo') Your SEO docs @elseif($type == 'info') Information docs @endif
@stop

@section('content')
<div class="page-heading text-center">
    <h1>@if($type == 'seo') SEO DOCUMENTS @elseif($type == 'info') INFORMATION DOCUMENTS @endif</h1>

    @if($type == 'seo')
    <p>Welcome to your SEO documents page, click a pdf to view</p>
    @else
    <p>Welcome to your information page, click a pdf to view</p>
    @endif
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
			@if(count($files))
				<table class="table table-ti-border">
	            @foreach($files as $file)
	            	<tr>
						<td class="goto-column click-only">
							<a href="{{ config('app.asset_url') . $file->filepath }}" class="show-on-hover icon-download" target="_blank"></a>
						</td>
						<td class="goto-column touch-only">
							<a href="{{ config('app.asset_url') . $file->filepath }}" class="icon-download" target="_blank"></a>
						</td>
						<td class="td-adjust text-left">
	            			{{ $file->filename }}
						</td>
						<td class="td-adjust text-center">
							{{ date('d/m/y', strtotime($file->created_at)) }}
						</td>
					</tr>
	            @endforeach
				</table>
			@else
				<div class="alert alert-warning">
					There are no documents to view
				</div>
			@endif
		</div>
    </div>
</div>
@stop
