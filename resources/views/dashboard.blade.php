@extends('includes.layout')

@section('sectionTitle')
    Your Services
@stop

@section('content')
@if(!auth()->user()->admin && session('ticket_success') && session('company_slug'))
@include('tickets.ticketSuccess', ['company_slug' => session('company_slug')]);
@else

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
        {{-- If there are no ads to display --}}
        @if(count(auth()->user()->Adverts) == 0)
        <div class="col-xs-12">
        @else
        <div class="col-sm-9 col-xs-12">
        @endif
            <div class="btn-section row">
                @if(auth()->user()->admin)
                    {{-- Tickets Section --}}
                    <a href="#" class="btn-section-link btn-maintenance-support">
                        <strong>Maintenance &amp; Support</strong>
                        <p>Click here to upload a request for web development, blog posts, ask a question about your website, download SEO documents or get a quote.</p>
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
                        <p>Create a new client, add new clients and determine who recieves emails and how you would like Ti to respond.</p>
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
                        <p>Click here to manage adverts displayed to clients.</p>
                    </a>
                    <div class="clearfix banners-container">
                        <div class="col-md-12 ajaxable" id="banners-div" @if(!isset($_GET['banners'])) style="display:none;" @endif>
                            @if(isset($_GET['banners']))
                            <?php $c = new TargetInk\Http\Controllers\AdvertController; ?>
                            {!! $c->index() !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="banner-table-div">
                            @if(isset($_GET['banners']) && request()->input('client_id'))
                            <?php $c = new TargetInk\Http\Controllers\AdvertController; ?>
                            {!! $c->show(request()->input('client_id')) !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="banner-form-div" style="display:none;"></div>
                    </div>

                    {{-- Services Section --}}
                    <a href="#" class="btn-section-link btn-services" id="servicesDiv">
                        <strong>Services</strong>
                        <p>This icon alows you to add products to your list of links on your clients landing pages - products appear on all client pages.</p>
                    </a>
                    <div class="clearfix services-container">
                        <div class="col-md-12 ajaxable" id="services-div" @if(!isset($_GET['services'])) style="display:none;" @endif>
                            @if(isset($_GET['services']))
                            <?php $c = new TargetInk\Http\Controllers\ServicesController; ?>
                            {!! $c->index() !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="services-table-div">
                            @if(isset($_GET['services']) && request()->input('client_id'))
                            <?php $c = new TargetInk\Http\Controllers\ServicesController; ?>
                            {!! $c->show(request()->input('client_id')) !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="services-form-div" style="display:none;"></div>
                    </div>

                    {{-- SEO Section --}}
                    <a href="#" class="btn-section-link btn-seo-reports-admin">
                        <strong>Upload SEO Reports</strong>
                        <p>This icon allows you to upload SEO Reports to clients accounts.</p>
                    </a>
                    <div class="clearfix services-container">
                        <div class="col-md-12 ajaxable" id="seo-div" @if(!isset($_GET['seo'])) style="display:none;" @endif>
                            @if(isset($_GET['seo']))
                            <?php $c = new TargetInk\Http\Controllers\AdminDocumentsController; ?>
                            {!! $c->index('seo') !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="seo-table-div">
                            @if(isset($_GET['seo']) && request()->input('client_id'))
                            <?php $c = new TargetInk\Http\Controllers\AdminDocumentsController; ?>
                            {!! $c->show('seo', request()->input('client_id')) !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="seo-form-div" style="display:none;"></div>
                    </div>

                    {{-- Information Section --}}
                    <a href="#" class="btn-section-link btn-information-documents-admin">
                        <strong>Upload Information Documents</strong>
                        <p>This icon allows you to upload information documents for clients to refer to.</p>
                    </a>
                    <div class="clearfix services-container">
                        <div class="col-md-12 ajaxable" id="info-div" @if(!isset($_GET['info'])) style="display:none;" @endif>
                            @if(isset($_GET['info']))
                            <?php $c = new TargetInk\Http\Controllers\AdminDocumentsController; ?>
                            {!! $c->index('info') !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="info-table-div">
                            @if(isset($_GET['info']) && request()->input('client_id'))
                            <?php $c = new TargetInk\Http\Controllers\AdminDocumentsController; ?>
                            {!! $c->show('info', request()->input('client_id')) !!}
                            @endif
                        </div>
                        <div class="col-md-12 ajaxable" id="info-form-div" style="display:none;"></div>
                    </div>
                @else
                    <a href="{{ url(auth()->user()->company_slug . '/tickets') }}" class="btn-section-link btn-maintenance-support">
                        <strong>Maintenance &amp; Support</strong>
                        <p>Click here to upload a request for web development, blog posts, ask a question about your website, download SEO documents or get a quote.</p>
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
@endif
@endsection

@section('styles')
    @if(count(auth()->user()->services))
        <style type="text/css">
            @foreach(auth()->user()->services as $service)
                .btn-section-{{ $service->id }}:before {
                    background:none;
                    background-image: url('{{ $service->icon }}?w=146&amp;h=146&amp;fit=max') !important;
                    background-position-y: top;
                    background-repeat: no-repeat;
                }
                .btn-section-{{ $service->id }}:hover:before {
                    background-image: url('{{ $service->icon_rollover }}?w=146&amp;h=146&amp;fit=max') !important;
                }
            @endforeach
        </style>
    @endif
@stop
