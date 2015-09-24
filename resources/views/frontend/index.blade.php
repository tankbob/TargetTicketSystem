@extends('frontend.includes.layout')

@section('title')
	Your Services
@stop

@section('content')
	<div>
		<a href="/maintenance">
		<h1>
			Maintenance &amp; Support
		</h1>
		</a>
		<p>
			Click here to upload a request for web development, blog post, ask a question about your website, download SEO documents or get a quote.
		</p>
	</div>
	<div>
		<a href="/seo">
		<h1>
			SEO Documents
		</h1>
		</a>
		<p>
			Click here to view your current &amp; previous SEO Docs.
		</p>
	</div>
	<div>
		<a href="/docs">
		<h1>
			Information Documents
		</h1>
		</a>
		<p>
			Click here to view Target Ink documents. Information, instructions and Term &amp; Conditions.
		</p>
	</div>
@stop