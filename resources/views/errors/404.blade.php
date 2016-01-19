@extends('includes.layout')

@section('sectionTitle')
    404 Not Found
@stop

@section('content')
<div class="page-heading text-center">
    <h1>404 Not Found</h1>

    <p>Theres nothing here, return to the <a href="{{ url('/') }}">Dashboard</a></p>
</div>
@stop
