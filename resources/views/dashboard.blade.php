@extends('includes.layout')

@section('sectionTitle')
    Your Services
@stop

@section('content')
<div class="page-heading text-center">
    <h1>Choose a Service</h1>

    @if(auth()->user()->admin)
    <p>Welcome to Support Administration Hub, please choose a service</p>
    @else
    <p>Welcome to your Maintenance &amp; Support Hub, please choose a service</p>
    @endif
</div>

<div class="page-content">
    <div class="row">
        @if(auth()->user()->admin)
        <div class="col-xs-12">
        @else
        <div class="col-sm-9 col-xs-12">
        @endif
            <div class="btn-section row">
                @if(auth()->user()->admin)
                    {{-- Tickets Section --}}
                    <a href="#" class="btn-section-link btn-maintenance-support">
                        <strong>Maintenance &amp; Support</strong>
                        <p>Click here to upload a request for web development, blog posts, ask a question about your website, download SEO documents or get a quote</p>
                    </a>
                    <div class="ajaxable" id="maintenance-support-div" @if(!isset($_GET['maintenance'])) style="display:none;" @endif>
                        @if(isset($_GET['maintenance']))
                        <?php $c = new TargetInk\Http\Controllers\AppController; ?>
                        {!! $c->showMaintenance() !!}
                        @endif
                    </div>

                    {{-- Clients Section --}}
                    <a href="#" class="btn-section-link btn-clients">
                        <strong>Clients</strong>
                        <p>Create a new client, add new clients and determine who recieves emails and how you would like Ti to respond</p>
                    </a>
                    <div class="ajaxable" id="clients-div" @if(!isset($_GET['clients'])) style="display:none;" @endif>
                        @if(isset($_GET['clients']))
                        <?php $c = new TargetInk\Http\Controllers\ClientsController; ?>
                        {!! $c->index() !!}
                        @endif
                    </div>

                    {{-- Banners Section --}}
                    <a href="#" class="btn-section-link btn-banners" id="advertDiv">
                        <strong>Adverts</strong>
                        <p>Click here to manage adverts displayed to clients</p>
                    </a>
                    <div class="row banners-container">
                        <div class="col-md-12 ajaxable" id="banners-div" @if(!isset($_GET['banners'])) style="display:none;" @endif>
                            @if(isset($_GET['banners']))
                            <?php $c = new TargetInk\Http\Controllers\AdvertController; ?>
                            {!! $c->index() !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="banner-table-div"></div>
                        <div class="col-md-12 ajaxable" id="banner-form-div"></div>
                    </div>

                    {{-- Services Section --}}
                    <a href="#" class="btn-section-link btn-services" id="servicesDiv">
                        <strong>Services</strong>
                        <p>This icon alows you to add products to your list of links on your clients landing pages - products appear on all client pages.</p>
                    </a>
                    <div class="row services-container">
                        <div class="col-md-12 ajaxable" id="services-div" @if(!isset($_GET['services'])) style="display:none;" @endif>
                            @if(isset($_GET['services']))
                            <?php $c = new TargetInk\Http\Controllers\ServicesController; ?>
                            {!! $c->index() !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="services-table-div"></div>
                        <div class="col-md-12 ajaxable" id="services-form-div"></div>
                    </div>

                    {{-- SEO Section TODO --}}
                    <a href="#" class="btn-section-link btn-seo-reports-admin">
                        <strong>Upload SEO Reports</strong>
                        <p>This icon allows you to upload SEO Reports to clients accounts.</p>
                    </a>
                    {!! Form::open(['url' => '/documents/seo', 'method' => 'POST', 'id' => 'new-seo-form', 'files' => true]) !!}
                        <div class="ajaxable" id="seo-div"></div>
                        <div class="ajaxable" id="seo-table-div"></div>
                        <div class="ajaxable" id="seo-form-div"></div>
                    {!! Form::close() !!}

                    {{-- Information Section TODO --}}
                    <a href="#" class="btn-section-link btn-information-documents-admin">
                        <strong>Upload Information Documents</strong>
                        <p>This icon allows you to upload information documents for clients to refer to.</p>
                    </a>
                    {!! Form::open(['url' => '/documents/info', 'method' => 'POST', 'id' => 'new-info-form', 'files' => true]) !!}
                        <div class="ajaxable" id="info-div"></div>
                        <div class="ajaxable" id="info-table-div"></div>
                        <div class="ajaxable" id="info-form-div"></div>
                    {!! Form::close() !!}
                @else
                    <a href="{{ url(auth()->user()->company_slug . '/tickets') }}" class="btn-section-link btn-maintenance-support">
                        <strong>Maintenance &amp; Support</strong>
                        <p>Click here to upload a request for web development, blog posts, ask a question about your website, download SEO documents or get a quote</p>
                    </a>

                    <a href="{{ url(auth()->user()->company_slug . '/documents/seo') }}" class="btn-section-link btn-seo-reports">
                        <strong>SEO Documents</strong>
                        <p>Click here to view your current &amp; previous SEO Docs.</p>
                    </a>

                    <a href="{{ url(auth()->user()->company_slug . '/documents/info') }}" class="btn-section-link btn-information-documents">
                        <strong>Information Documents</strong>
                        <p>Click here to view Target Ink documents. Information, instructions and Term &amp; Conditions.</p>
                    </a>

                    @if(count(auth()->user()->services))
                        @foreach(auth()->user()->services as $service)
                             <a href="{{  $service->link }}" target="#blank" class="btn-section-link btn-section-{{ $service->id }}">
                                <strong>{{ $service->heading }}</strong>
                                <p>{!! nl2br($service->text) !!}</p>
                            </a>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
        @if(!auth()->user()->admin)
        <div class="col-sm-3 hidden-xs text-center">
            @include('includes.banners')
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
    @if(count(auth()->user()->services))
        <style type="text/css">
            @foreach(auth()->user()->services as $service)
                .btn-section-{{ $service->id }} {
                    background-image: url('/files/services/{{ $service->icon }}') !important;
                    background-position-y: top;
                    background-repeat: no-repeat;
                }
                .btn-section-{{ $service->id }}:hover {
                    background-image: url('/files/services/{{ $service->icon_rollover }}') !important;
                }
            @endforeach
        </style>
    @endif
@stop
