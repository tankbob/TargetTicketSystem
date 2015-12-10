@extends('includes.layout')

@section('sectionTitle')
    Your Services
@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            @if(Request::get('advert'))
                $("#banners-div").load("/banners");
                $("#banner-table-div").load("/banners/" + {{ Request::get('advert') }});
                $("#banner-form-div").html("<div class='alert alert-success'>The Advert has been uploaded successfully</div>");
            @elseif(Request::get('seo'))
                $("#seo-div").load("/documents/seo");
                $("#seo-table-div").load("/documents/seo/" + {{ Request::get('seo') }});
                $("#seo-form-div").html("<div class='alert alert-success'>The SEO Document has been uploaded successfully</div>");
            @elseif(Request::get('info'))
                $("#info-div").load("/documents/info");
                $("#info-table-div").load("/documents/info/" + {{ Request::get('info') }});
                $("#info-form-div").html("<div class='alert alert-success'>The info Document has been uploaded successfully</div>");
            @elseif(Request::get('service'))
                $("#services-div").load("/services");
                $("#services-table-div").load("/services/" + {{ Request::get('service') }});
                $("#services-form-div").html("<div class='alert alert-success'>The service has been added successfully</div>");
            @endif
        });
    </script>
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
                    <a href="#" class="btn-section-link btn-maintenance-support">
                        <strong>Maintenance &amp; Support</strong>
                        <p>Click here to upload a request for web development, blog posts, ask a question about your website, download SEO documents or get a quote</p>
                    </a>

                    <div id="maintenance-support-div"></div>

                    <a href="#" class="btn-section-link btn-clients">
                        <strong>Clients</strong>
                        <p>Create a new client, add new clients and determine who recieves emails and how you would like Ti to respond</p>
                    </a>

                    <div id="clients-div"></div>

                    <a href="#" class="btn-section-link btn-banners" id="advertDiv">
                        <strong>Adverts</strong>
                        <p>Click here to manage adverts displayed to clients</p>
                    </a>
                    {!! Form::open(['url' => '/banners', 'method' => 'POST', 'id' => 'newBannerForm', 'files' => true]) !!}
                        <div id="banners-div"></div>
                        <div id="banner-table-div"></div>
                        <div id="banner-form-div"></div>
                    {!! Form::close() !!}

                    <a href="#" class="btn-section-link btn-services">
                        <strong>Services</strong>
                        <p>This icon alows you to add products to your list of links on your clients landing pages - products appear on all client pages.</p>
                    </a>
                    {!! Form::open(['url' => '/services', 'method' => 'POST', 'id' => 'new-services-form', 'files' => true]) !!}
                        <div id="services-div"></div>
                        <div id="services-table-div"></div>
                        <div id="services-form-div"></div>
                    {!! Form::close() !!}

                    <a href="#" class="btn-section-link btn-seo-reports-admin">
                        <strong>Upload SEO Reports</strong>
                        <p>This icon allows you to upload SEO Reports to clients accounts.</p>
                    </a>
                    {!! Form::open(['url' => '/documents/seo', 'method' => 'POST', 'id' => 'new-seo-form', 'files' => true]) !!}
                        <div id="seo-div"></div>
                        <div id="seo-table-div"></div>
                        <div id="seo-form-div"></div>
                    {!! Form::close() !!}

                    <a href="#" class="btn-section-link btn-information-documents-admin">
                        <strong>Upload Information Documents</strong>
                        <p>This icon allows you to upload information documents for clients to refer to.</p>
                    </a>
                    {!! Form::open(['url' => '/documents/info', 'method' => 'POST', 'id' => 'new-info-form', 'files' => true]) !!}
                        <div id="info-div"></div>
                        <div id="info-table-div"></div>
                        <div id="info-form-div"></div>
                    {!! Form::close() !!}
                @else
                    <a href="{{ url(auth()->user()->company_slug.'/tickets') }}" class="btn-section-link btn-maintenance-support">
                        <strong>Maintenance &amp; Support</strong>
                        <p>Click here to upload a request for web development, blog posts, ask a question about your website, download SEO documents or get a quote</p>
                    </a>

                    <a href="{{ url(auth()->user()->company_slug.'/documents/seo') }}" class="btn-section-link btn-seo-reports">
                        <strong>SEO Documents</strong>
                        <p>Click here to view your current &amp; previous SEO Docs.</p>
                    </a>

                    <a href="{{ url(auth()->user()->company_slug.'/documents/info') }}" class="btn-section-link btn-information-documents">
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
