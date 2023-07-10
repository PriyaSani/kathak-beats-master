$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.validator.addMethod("customemail", 
        function(value, element) {
            return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
        }, 
        "Please enter email id along with domain name."
    );

    jQuery.validator.addMethod("greaterThan", function(value, element, params) {

        if (!/Invalid|NaN/.test(new Date(value))) {
            return new Date(value) > new Date($(params).val());
        }

        return isNaN(value) && isNaN($(params).val()) 
            || (Number(value) > Number($(params).val())); 
    },'End date must be after start date');

    // Login form Validation
    $("#loginForm").validate({
        errorElement: 'div',
        rules: {
            email:{
                required: true,
                email: true,
                customemail:true,
                remote: {
                    url: "/check-login-email",
                    method: "post",
                },  

            },
        },  
        messages: {
            email: {
                required: "Enter email address",
                remote:'Please enter registerd email.'
            },
        },
    });

    $("#signup").validate({
        errorElement: 'div',
        rules: {
            email:{
                required: true,
                email: true,
                customemail:true,
                remote: {
                    url: "/check-signup-email",
                    method: "post",
                },  
            },
            name:{
                required: true,
            },
            contact_number:{
                required: true,
            },
            whatsapp_contact:{
                required: true,
            },
            dob:{
                required: true,
            },
            country:{
                required: true,
            },
            state:{
                required: true,
            },
            city:{
                required: true,
            },
            address:{
                required: true,
            }
        },  
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'contact_number') {                   
                error.insertAfter('#contactNumber');
            } else if(element.attr("name") == 'whatsapp_contact'){ 
                error.insertAfter('#whatsappNumber');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            email: {
                required: "Enter email address",
                remote:'Email alerady exists'
            },
            name:{
                required: "Please enter name",
            },
            contact_number:{
                required: "Please enter contact number",
            },
            whatsapp_contact:{
                required: "Please enter whatsapp contct",
            },
            dob:{
                required: "Please select DOB",
            },
            country:{
                required: "Please Select Country",
            },
            state:{
                required: "Please select state",
            },
            city:{
                required: "Please select city",
            },
            address:{
                required: "Please select address",
            }
        },
    });
    
    $("#contactForm").validate({
        errorElement: 'div',
        rules: {
            full_name :{
                required: true,
            },
            email:{
                required: true,
                email: true,
                customemail:true,
            },
            contact_number:{
                required: true,
            },
            whatsapp_number:{
                required: true,
            },
            purpose:{
                required: true,
            },
            address:{
                required: true,
            }
        },  
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'contact_number') {                   
                error.insertAfter('#contactNumber');
            } else if(element.attr("name") == 'whatsapp_number'){ 
                error.insertAfter('#whatsappNumber');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            email: {
                required: "Enter email address",
                remote:'Email alerady exists'
            },
            full_name:{
                required: "Please enter name",
            },
            contact_number:{
                required: "Please enter contact number",
            },
            whatsapp_number:{
                required: "Please enter whatsapp number",
            },
            purpose:{
                required: "Please select purpose",
            },
            address:{
                required: "Please select address",
            }
        },
    });
    
    $('.batchFilter').on('click',function(){
        var type = $(this).data('id');
        $('.batchFilter').removeClass('active');
        if(type == 'studio'){
            $('.onlinebatch').hide();
            $('.studiobatch').show();
            $('.batchstudio').addClass('active');
        } else if(type == 'online'){
            $('.onlinebatch').show();
            $('.studiobatch').hide();
            $('.batchonline').addClass('active');
        } else {
            $('.onlinebatch').show();
            $('.studiobatch').show();
            $('.batchall').addClass('active');
        }
    });  

    $('.workshopFilter').on('click',function(){
        var type = $(this).data('id');
        $('.workshopFilter').removeClass('active');
        if(type == 'studio'){
            $('.onlineworkshop').hide();
            $('.studioworkshop').show();
            $('.workshopstudio').addClass('active');
        } else if(type == 'online'){
            $('.onlineworkshop').show();
            $('.studioworkshop').hide();
            $('.workshoponline').addClass('active');
        } else {
            $('.onlineworkshop').show();
            $('.studioworkshop').show();
            $('.workshopall').addClass('active');
        }
    });  
});






