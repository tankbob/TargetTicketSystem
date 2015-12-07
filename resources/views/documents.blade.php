@extends('includes.layout')

@section('sectionTitle')
	@if($type == 'seo') Your SEO docs @elseif($type == 'info') Information docs @endif
@stop

@section('content')
<div class="page-heading text-center">
    <h1>@if($type == 'seo') SEO DOCUMENTS @elseif($type == 'info') INFORMATION DOCUMENTS @endif</h1>
    <p>Welcome to @if($type == 'seo') your SEO @elseif($type == 'info') our information @endif, Click a pdf to view</p>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            @foreach($files as $file)
            	<div>
            		<a href="/files/documents/{{$file->filepath}}">ICON</a> {{$file->filename}} {{date('d/m/y', strtotime($file->created_at))}}
            	</div>
            @endforeach
		</div>
    </div>
</div>
@stop
