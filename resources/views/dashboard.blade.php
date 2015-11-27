@extends('includes.layout')

@section('sectionTitle')
    Your Services
@stop

@section('scripts')
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">

    <script type="text/javascript">
        $(document).ready(function(){
            // Set up the csrf token for all ajax requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 

            $('.btn-maintenance-support').on('click', function(event){
                event.preventDefault;
                $( "#maintenance-support-div" ).load( "/dashboard/maintenance" );
            });

            $('.btn-clients').on('click', function(event){
                event.preventDefault();
                $( "#clients-div" ).load( "/clients" );
            });

            $('.btn-banners').on('click', function(event){
                event.preventDefault();
                $("#banners-div").load("/banners");
            });

            $('#clients-div').on('click', '.clientFormToggler', function(event){
                event.preventDefault();
                if($(this).attr('clientId') == 0){
                    $("#clientFormDiv").load("/clients/create");
                }else{
                    $("#clientFormDiv").load("/clients/"+$(this).attr('clientId')+"/edit");
                }
            });

            $("#banners-div").on('change', '#banner-customer-select', function(event){
                event.preventDefault();
                if($(this).val() != ''){
                    $("#banner-table-div").load("/banners/"+$(this).val());
                }else{
                    $("#banner-table-div").html('');
                }
            });

            $('#banners-div').on('click', '.bannerDelete', function(event){
                event.preventDefault();
                if(window.confirm("Are you sure you want to delete this advert permanently?")){
                    $.ajax({
                        type: 'DELETE',
                        url: '/banners/'+$(this).attr('bannerId'),
                        success: function(response) {
                            var res = $.parseJSON(response);
                            $("#banner-row-"+res.id).remove();
                            $("#bannerFormDiv").html('<div class="alert-success">'+res.success+'</div>');
                        }
                    });
                }
            });

             $('#banners-div').on('click', '.bannerFormToggler', function(event){
                event.preventDefault();
                $("#bannerFormDiv").load("/banners/create");
                //Validation     
            });

            $('#clients-div').on('submit', '#clientForm', function(event){
                event.preventDefault();

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        var res = $.parseJSON(response);
                        $("#clientFormDiv").html('<div class="alert-success">'+res.success+'</div>');
                        if(res.method == 'create'){
                            $('#client-table tbody').append('<tr id="client-row-'+res.id+'"><td><a href="#" class="clientFormToggler" clientId="'+res.id+'">GOTOICON</a></td><td>'+res.email+'</td><td>'+res.name+'</td><td></td><td><a href="#" class="clientDelete" clientId="'+res.id+'">DELETE ICON</a></td></tr>');
                        }else{
                            $("#client-name-"+res.id).html(res.name);
                            $("#client-email-"+res.id).html(res.email);
                        }
                    }
                });
            });

            $('#clients-div').on('click', '.clientDelete', function(event){
                event.preventDefault();
                if(window.confirm("Are you sure you want to delete this user permanently?")){
                    $.ajax({
                        type: 'DELETE',
                        url: '/clients/'+$(this).attr('clientId'),
                        success: function(response) {
                            var res = $.parseJSON(response);
                            $("#client-row-"+res.id).remove();
                            $("#clientFormDiv").html('<div class="alert-success">'+res.success+'</div>');
                        }
                    });
                }
            });

            //Validate
            jQuery.validator.setDefaults({
            });

            $('#newBannerForm').validate({
                rules:{
                    client_id: {
                        required: true
                    }, image:{
                        required: true
                    }, url: {
                        required: true,
                        url: true
                    }, name: {
                        required: true
                    },
                }, messages:{
                    category_id: "Please choose an option",
                }
            });

            @if(Request::get('advert'))
                $("#banners-div").load("/banners");
                $("#banner-table-div").load("/banners/"+{{Request::get('advert')}});
                $("#bannerFormDiv").html("<div class='alert alert-success'>The Advert has been uploaded successfully</div>");
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

                    <div href="#" id="clients-div"></div>

                    <a href="#" class="btn-section-link btn-banners" id="advertDiv">
                        <strong>Adverts</strong>
                        <p>Click here to manage adverts displayed to clients</p>
                    </a>
                    {!! Form::open(['url' => '/banners', 'method' => 'POST', 'id' => 'newBannerForm', 'files' => true]) !!}
                        <div id="banners-div"></div>
                        <div id="banner-table-div"></div>
                        <div id="bannerFormDiv"></div>
                    {!! Form::close() !!}

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