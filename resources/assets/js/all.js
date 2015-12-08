/*global $, document */
/*jslint
    this
*/
"use strict";

var attachmentCounter = 1;

function adaptMenu() {

    if ($(window).width() < 720) {
        $('.main-nav').removeClass('btn-group-justified');
        $('.main-nav').addClass('btn-group-vertical');
        $('.main-nav').addClass('btn-block');
    } else {
        $('.main-nav').addClass('btn-group-justified');
        $('.main-nav').removeClass('btn-group-vertical');
        $('.main-nav').removeClass('btn-block');
    }
}
$(window).resize(function () {
    adaptMenu();
});
adaptMenu();
$(document).ready(function () {
    // Set up the csrf token for all ajax requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.btn-maintenance-support').on('click', function (event) {
        event.preventDefault;
        $("#maintenance-support-div").load("/dashboard/maintenance");
    });
    $('.btn-clients').on('click', function (event) {
        event.preventDefault();
        $("#clients-div").load("/clients");
    });
    $('.btn-banners').on('click', function (event) {
        event.preventDefault();
        $("#banners-div").load("/banners");
    });
    $('.btn-services').on('click', function (event) {
        event.preventDefault();
        $("#services-div").load("/services");
    });
    $('#clients-div').on('click', '.clientFormToggler', function (event) {
        event.preventDefault();
        if ($(this).attr('clientId') == 0) {
            $("#clientFormDiv").load("/clients/create");
        } else {
            $("#clientFormDiv").load("/clients/" + $(this).attr('clientId') + "/edit");
        }
    });
    $("#banners-div").on('change', '#banner-customer-select', function (event) {
        event.preventDefault();
        if ($(this).val() != '') {
            $("#banner-table-div").load("/banners/" + $(this).val());
        } else {
            $("#banner-table-div").html('');
        }
    });
    $('#banners-div').on('click', '.bannerDelete', function (event) {
        event.preventDefault();
        if (window.confirm("Are you sure you want to delete this advert permanently?")) {
            $.ajax({
                type: 'DELETE',
                url: '/banners/' + $(this).attr('bannerId'),
                success: function (response) {
                    var res = $.parseJSON(response);
                    $("#banner-row-" + res.id).remove();
                    $("#banner-form-div").html('<div class="alert-success">' + res.success + '</div>');
                }
            });
        }
    });
    $('#banners-div').on('click', '.bannerFormToggler', function (event) {
        event.preventDefault();
        $("#banner-form-div").load("/banners/create");
        //Validation
    });
    $('#clients-div').on('submit', '#clientForm', function (event) {
        event.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                var res = $.parseJSON(response);
                $("#clientFormDiv").html('<div class="alert-success">' + res.success + '</div>');
                if (res.method == 'create') {
                    $('#client-table tbody').append('<tr id="client-row-' + res.id + '"><td><a href="#" class="clientFormToggler" clientId="' + res.id + '">GOTOICON</a></td><td>' + res.email + '</td><td>' + res.name + '</td><td></td><td><a href="#" class="clientDelete" clientId="' + res.id + '">DELETE ICON</a></td></tr>');
                } else {
                    $("#client-name-" + res.id).html(res.name);
                    $("#client-email-" + res.id).html(res.email);
                }
            }
        });
    });
    $('#clients-div').on('click', '.clientDelete', function (event) {
        event.preventDefault();
        if (window.confirm("Are you sure you want to delete this user permanently?")) {
            $.ajax({
                type: 'DELETE',
                url: '/clients/' + $(this).attr('clientId'),
                success: function (response) {
                    var res = $.parseJSON(response);
                    $("#client-row-" + res.id).remove();
                    $("#clientFormDiv").html('<div class="alert-success">' + res.success + '</div>');
                }
            });
        }
    });
    $('.btn-services').on('click', function (event) {
        event.preventDefault();
        $("#services-div").load("/services");
    });
    $("#services-div").on('change', '#service-customer-select', function (event) {
        event.preventDefault();
        if ($(this).val() != '') {
            $("#services-table-div").load("/services/" + $(this).val());
        } else {
            $("#services-table-div").html('');
        }
    });
    $('#services-div').on('click', '.services-form-toggler', function (event) {
        event.preventDefault();
        $('#services-form-div').load("/services/create");
    });
    $('#services-table-div').on('click', '.serviceDelete', function (event) {
        event.preventDefault();
        if (window.confirm("Are you sure you want to delete this document permanently?")) {
            $.ajax({
                type: 'DELETE',
                url: '/services/' + $(this).attr('serviceId'),
                success: function (response) {
                    var res = $.parseJSON(response);
                    $("#service-row-" + res.id).remove();
                    $("#services-form-div").html('<div class="alert-success">' + res.success + '</div>');
                }
            });
        }
    });
    $('.btn-seo-reports-admin').on('click', function (event) {
        event.preventDefault();
        $('#seo-div').load("/documents/seo");
    });
    $('#seo-div').on('change', '#seo-customer-select', function (event) {
        event.preventDefault();
        if ($(this).val() != '') {
            $("#seo-table-div").load("/documents/seo/" + $(this).val());
        } else {
            $("#seo-table-div").html('');
        }
    });
    $('#seo-div').on('click', '.seo-form-toggler', function (event) {
        event.preventDefault();
        $('#seo-form-div').load("/documents/seo/create");
    });
    $('#seo-table-div').on('click', '.seoDelete', function (event) {
        event.preventDefault();
        if (window.confirm("Are you sure you want to delete this document permanently?")) {
            $.ajax({
                type: 'DELETE',
                url: '/documents/seo/' + $(this).attr('fileId'),
                success: function (response) {
                    var res = $.parseJSON(response);
                    $("#seo-row-" + res.id).remove();
                    $("#seo-form-div").html('<div class="alert-success">' + res.success + '</div>');
                }
            });
        }
    });
    $('#info-table-div').on('click', '.infoDelete', function (event) {
        event.preventDefault();
        if (window.confirm("Are you sure you want to delete this document permanently?")) {
            $.ajax({
                type: 'DELETE',
                url: '/documents/info/' + $(this).attr('fileId'),
                success: function (response) {
                    var res = $.parseJSON(response);
                    $("#info-row-" + res.id).remove();
                    $("#info-form-div").html('<div class="alert-success">' + res.success + '</div>');
                }
            });
        }
    });
    $('.btn-information-documents-admin').on('click', function (event) {
        event.preventDefault();
        $('#info-div').load("/documents/info");
    });
    $('#info-div').on('change', '#info-customer-select', function (event) {
        event.preventDefault();
        if ($(this).val() != '') {
            $("#info-table-div").load("/documents/info/" + $(this).val());
        } else {
            $("#info-table-div").html('');
        }
    });
    $('#info-div').on('click', '.info-form-toggler', function (event) {
        event.preventDefault();
        $('#info-form-div').load("/documents/info/create");
    });
    //Validate
    jQuery.validator.setDefaults({});
    $('#newBannerForm').validate({
        rules: {
            client_id: {
                required: true
            },
            image: {
                required: true
            },
            url: {
                required: true,
                url: true
            },
            name: {
                required: true
            }
        },
        messages: {
            category_id: "Please choose an option"
        }
    });
    $('#new-seo-form').validate({
        rules: {
            client_id: {
                required: true
            },
            filename: {
                required: true
            },
            file: {
                required: true
            }
        }
    });
    $('#new-info-form').validate({
        rules: {
            client_id: {
                required: true
            },
            filename: {
                required: true
            },
            file: {
                required: true
            }
        }
    });
    $('#new-services-form').validate({
        rules: {
            client_id: {
                required: true
            },
            icon: {
                required: true
            },
            icon_rollover: {
                required: true
            },
            heading: {
                required: true
            },
            link: {
                required: true,
                url: true
            },
            text: {
                required: true
            }
        }
    });

    $('.sorted_table').sortable({
        containerSelector: 'table',
        handle: 'i.icon-move',
        itemPath: '> tbody',
        itemSelector: 'tr',
        placeholder: '<tr class="placeholder"/>',
        onDrop: function ($item, container, _super, event) {

            var new_order = [];
            $("#ticket_table tbody").find("tr").each(function () {
                new_order.push(this.id);
            });

            $.ajax({
                type: "POST",
                url: '/api/ticketsort',
                data: {
                    'user_id': $client_id,
                    'archived': $archived,
                    'new_order': new_order
                },
                success: function (response) {

                }
            });

            $item.removeClass(container.group.options.draggedClass).removeAttr("style")
            $("body").removeClass(container.group.options.bodyClass)
        }
    });

    // Ticket creation
    $("#attachmentDiv").on('change', '.fileInput', function (){
        addFileInput(this);
    });

    $('.type').on('change', function(){
        toggleFormFields($('.type:checked').val());
    });

    toggleFormFields($('.type:checked').val());

    $('.dateInput').mask("99/99/9999",{placeholder:"DD/MM/YYYY"});
});

function toggleFormFields(typeValue){
    switch(typeValue) {
        case '1':
            $('#publishedAtDiv').addClass('hidden');
            $('#authorDiv').addClass('hidden');
            $('#categoriesDiv').addClass('hidden');
            $('#artitcleTitleDiv').addClass('hidden');
            $('#scheduleDiv').addClass('hidden');
            $('#content').attr('placeholder', 'Your Text');
            break;
        case '2':
            $('#publishedAtDiv').removeClass('hidden');
            $('#authorDiv').removeClass('hidden');
            $('#categoriesDiv').removeClass('hidden');
            $('#artitcleTitleDiv').removeClass('hidden');
            $('#scheduleDiv').addClass('hidden');
            $('#content').attr('placeholder', 'Notes (For content ideally please submit a word or text doc. below)');
            break;
        case '3':
            $('#publishedAtDiv').addClass('hidden');
            $('#authorDiv').addClass('hidden');
            $('#categoriesDiv').addClass('hidden');
            $('#artitcleTitleDiv').addClass('hidden');
            $('#scheduleDiv').removeClass('hidden');
            $('#content').attr('placeholder', 'Your Text');
            break;
        case '4':
            $('#publishedAtDiv').addClass('hidden');
            $('#authorDiv').addClass('hidden');
            $('#categoriesDiv').addClass('hidden');
            $('#artitcleTitleDiv').addClass('hidden');
            $('#scheduleDiv').addClass('hidden');
            $('#content').attr('placeholder', 'How can we help...');
            break;
        default:
            break;
    }
}

function addFileInput(fileinput){
    if($(fileinput).val() && $(fileinput).attr('attachmentID') == attachmentCounter){
        attachmentCounter ++;
        var html = '';
        html += '<div>';
            html += '<input class="fileInput" attachmentid="'+attachmentCounter+'" name="attachment-'+attachmentCounter+'" type="file">';
        html += '</div>';
        $('#attachmentDiv').append(html);
        $('#attachment_count').val(attachmentCounter);
    }
}
