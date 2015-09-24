@extends('includes.layout')

@section('content')
<div class="page-heading text-center">
    <h1>Choose a Service</h1>
    <p>Welcome to Support Administration Hub, please choose a service</p>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-sm-9 col-xs-12">
            <div class="btn-section row">
                <a href="#" class="btn-section-link btn-maintenance-support">
                    <strong>Maintenance &amp; Support</strong>
                    <p>Click here to upload a request for web development, blog posts, ask a question about your website, download SEO documents or get a quote</p>
                </a>

                <a href="#" class="btn-section-link btn-clients">
                    <strong>Clients</strong>
                    <p>Create a new client, add new clients and determine who recieves emails and how you would like Ti to respond</p>
                </a>

                <a href="#" class="btn-section-link btn-adverts">
                    <strong>Adverts</strong>
                    <p>Click here to manage adverts displayed to clients</p>
                </a>

                <a href="#" class="btn-section-link btn-services">
                    <strong>Services</strong>
                    <p>This icon alows you to add products to your list of links on your clients landing pages - products appear on all client pages.</p>
                </a>

                <a href="#" class="btn-section-link btn-seo-reports">
                    <strong>Upload SEO Reports</strong>
                    <p>This icon allows you to upload SEO Reports to clients accounts.</p>
                </a>

                <a href="#" class="btn-section-link btn-information-documents">
                    <strong>Upload Information Documents</strong>
                    <p>This icon allows you to upload information documents for clients to refer to.</p>
                </a>
            </div>
        </div>
        <div class="col-sm-3 hidden-xs text-center">
            @include('includes.adverts')
        </div>
    </div>
</div>
@endsection