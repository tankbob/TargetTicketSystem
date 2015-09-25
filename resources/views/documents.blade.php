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
        @if(auth()->user()->admin)
        <div class="col-xs-12">
        @else
        <div class="col-sm-9 col-xs-12">
        @endif
           
        @foreach($files as $file)
        	<div>
        		<a href="/{{$file->filepath}}">ICON</a> {{$file->filename}} {{date('d/m/y', strtotime($file->created_at))}}
        	</div>
        @endforeach

		</div>
		@if(!auth()->user()->admin)
	        <div class="col-sm-3 hidden-xs text-center">
	            @include('includes.adverts')
	        </div>
        @endif
    </div>
</div>











@stop