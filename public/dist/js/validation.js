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
                customemail:true

            },
            password:{
                required: true,
                minlength: 8
            }
        },  
        messages: {
            email: {
                required: "Enter email address",
            },
            password: {
                required: "Enter password",
                minlength: "Your password must be at least 8 characters long"
            }
        },
    });

    // Admin password validation
    $("#resetPassword").validate({
        errorElement: 'div',
        rules: {
            email:{
                required: true,
                email: true
            },
            password:{
                required: true,
                minlength: 8
            },
            password_confirmation:{
                required: true,
                equalTo: "#password",
                minlength: 8
            }
        },  
        messages: {
            email: "Enter valid email",
            password: {
                required: "Enter password",
            },
            password_confirmation: {
                required: "Enter confirm password",
                equalTo: "Confirm password does not match with new password",
            }
        },
    });
    

    // Reset password Email Id validation
    $("#forgotForm").validate({
        errorElement: 'div',
        rules: {
            email:{
                required: true,
                customemail:true
            },
        },  
        messages: {
            required: "Enter email",
        },
    });

    // Admin Change Password validation
    $("#changePassword").validate({
        errorElement : 'div',
        rules: {
            old_password: {
                required: true,
                minlength: 8
            },
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password : {
                required: true,
                minlength: 8,
                equalTo: "#new_password"
            }

        },
        messages: {
            old_password: {
                required: "Please Enter Current Password",
            },
            new_password:{
                required: "Please Enter New Password",
                minlength: "Your password must be at least 8 characters long",
            },
            confirm_password:{
                required: "Please Enter Confirm Password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with new password"
            }
        }
    });

    // Mobile no function for enter only digit
    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g,'');  
    });


    // User Form validation
    $("#userForm").validate({
        errorElement : 'div',
        rules: {
            first_name: "required",
            email:{
                required: true,
                remote: {
                    url: "/admin-panel/check-email",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },
            },
            mobile:{
                required: true,
                minlength:10
            },
            password: {
                required: true,
                minlength: 6
            },
            confirm_password : {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
            last_name: {
                required: true,
            },
        },
        messages: {
            first_name: "Enter first name",
            email:{
                required: "Enter valid email ID",
                remote: "Email already exists"
            },
            mobile:{
                required: "Enter mobile number",
            },
            password: {
                required: "Enter password",
            },
            confirm_password:{
                required: "Enter confirm password",
                equalTo: "Both password should be matched"
            },
            last_name: {
                required: "Enter last name",
            },
        }
    });


    $("#categoryForm").validate({
        errorElement : 'div',
        rules: {
            name: "required",
            description: {
                required: true,
            },
            priority:{
                required: true,
                remote: {
                    url: "/admin-panel/check-cat-priotiry",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },
            },
        },
        messages: {
            name: "Enter category name",
            priority:{
                required: "Enter priority",
                remote: "Priority already exists"
            },
            description:{
                required: "Enter description",
            }
        }
    });

    $("#updateProfile").validate({
        errorElement : 'div',
        rules: {
            name: "required",
            description: {
                required: true,
            },
            priority:{
                required: true,
                remote: {
                    url: "/admin-panel/check-cat-priotiry",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },
            },
        },
        messages: {
            name: "Enter category name",
            priority:{
                required: "Enter priority",
                remote: "Priority already exists"
            },
            description:{
                required: "Enter description",
            }
        }
    });

    $("#addFauclty").validate({
        errorElement : 'div',
        ignore: [],
        rules: {
            name: {
                required: true,
            },
            address: {
                required: true,
            },
            city:{
                required: true,  
            }, 
            state:{
                required: true,  
            }, 
            mobile:{
                required: true,
                remote: {
                    url: "/kb-backend/faculty/check-faculty-mobile",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },  
            }, 
            email:{
                required: true,
                customemail:true,
                remote: {
                    url: "/kb-backend/faculty/check-faculty-email",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },  
            }, 
            new_password:{
                required: true,  
                minlength: 8
            }, 
            confirm_password:{
                required: true,  
                minlength: 8,
                equalTo: "#new_password"
            }, 
            'module[]': {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'dashboard[]') {                   
                error.insertAfter('#dashboard');
            } else if(element.attr("name") == 'module[]'){ 
                error.insertAfter('#module');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            name: {
                required: 'Enter full name',
            },
            address: {
                required: 'Enter address',
            },
            city:{
                required: 'Enter city',  
            }, 
            state:{
                required: 'Enter state',  
            }, 
            mobile:{
                required: 'Enter mobile number',  
                remote: "Mobile number already exists"
            }, 
            email:{
                required: 'Enter email id',  
                remote: "Email id already exists"
            }, 
            new_password:{
                required: "Enter password",
                minlength: "Your password must be at least 8 characters long",
            },
            confirm_password:{
                required: "Enter confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with password"
            },
            'module[]': {
                required: "Select module"
            },
        }
    });

    $("#editFaculty").validate({
        errorElement : 'div',
        ignore: [],
        rules: {
            name: {
                required: true,
            },
            address: {
                required: true,
            },
            city:{
                required: true,  
            }, 
            state:{
                required: true,  
            }, 
            mobile:{
                required: true,
                remote: {
                    url: "/kb-backend/faculty/check-faculty-mobile",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },  
            }, 
            email:{
                required: true,
                customemail:true,
                remote: {
                    url: "/kb-backend/faculty/check-faculty-email",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },  
            }, 
            new_password:{
                minlength: 8
            }, 
            confirm_password:{
                minlength: 8,
                equalTo: "#new_password"
            }, 
            'module[]': {
                required: true,
            }
        },
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'dashboard[]') {                   
                error.insertAfter('#dashboard');
            } else if(element.attr("name") == 'module[]'){ 
                error.insertAfter('#module');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            name: {
                required: 'Enter full name',
            },
            address: {
                required: 'Enter address',
            },
            city:{
                required: 'Enter city',  
            }, 
            state:{
                required: 'Enter state',  
            }, 
            mobile:{
                required: 'Enter mobile number',  
                remote: "Mobile number already exists"
            }, 
            email:{
                required: 'Enter email id',  
                remote: "Email id already exists"
            }, 
            new_password:{
                minlength: "Your password must be at least 8 characters long",
            },
            confirm_password:{
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Confirm password does not match with password"
            },
            'module[]': {
                required: "Select module"
            }
        }
    });

    $("#addStudent").validate({
        errorElement : 'div',
        rules: {
            name: {
                required: true,
            },
            mobile:{
                required: true,
            }, 
            email:{
                required: true,
                customemail:true,
                remote: {
                    url: "/kb-backend/student/check-student-email",
                    method: "post",
                    data: {
                        id: function() {
                            return $( "#id" ).val();
                        },
                    }
                },  
            }, 
            wp_number: {
                required: true,
            },
            city:{
                required: true,  
            }, 
            state:{
                required: true,  
            }, 
            country:{
                required: true,  
            }, 
            
            address:{
                required: true,  
            }, 
            billing_cycle:{
                required: true,  
            }, 
            registration_mode:{
                required: true,  
            }, 
        },
        messages: {
            name: {
                required: 'Enter full name',
            },
            mobile:{
                required: 'Enter contact number',  
                remote: "Contact number already exists"
            }, 
            email:{
                required: 'Enter email id',  
                remote: "Email id already exists"
            },
            state:{
                required: 'Enter state',  
            }, 
            wp_number: {
                required: 'Enter whatsapp number',
            },
            city:{
                required: 'Enter city',  
            }, 
            country:{
                required: 'Enter country',  
            }, 
            
            address:{
                required: 'Enter full address',  
            }, 
            billing_cycle:{
                required: 'Select billing cycle',  
            }, 
            registration_mode:{
                required: 'Select registration mode',  
            }, 
        }
    });

    $("#addImage").validate({
        errorElement : 'div',
        ignore: [],
        rules: {
            grid_type: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'grid_type') {                   
                error.insertAfter('#grid');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            grid_type: {
                required: 'Select grid type',
            },
        }
    });

    $("#addVideo").validate({
        errorElement : 'div',
        ignore: [],
        rules: {
            grid_type: {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'grid_type') {                   
                error.insertAfter('#grid');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            grid_type: {
                required: 'Select grid type',
            },
        }
    });

    $("#studioValidation").validate({
        errorElement : 'div',
        rules: {
            name: {
                required: true,
            },
            city:{
                required: true,  
            }, 
            country:{
                required: true,  
            }, 
            state:{
                required: true,  
            }, 
            address:{
                required: true,  
            }, 
        },
        messages: {
            name: {
                required: 'Enter studio name',
            },
            city:{
                required: 'Enter city',  
            }, 
            country:{
                required: 'Enter country',  
            }, 
            state:{
                required: 'Enter state',  
            },     
            address:{
                required: 'Enter address',  
            }, 
        }
    });

     $("#addWorkshop").validate({
        // errorElement : 'span',
        ignore: [],
        rules: {
            engagement_type: {
                required: true,
            },
            engagement_mode:{
                required: true,
            }, 
            title: {
                required: true,
            },
            short_description:{
                required: true,  
            }, 
            price:{
                required: true,  
            }, 
            about:{
                required: true,  
            }, 
            content:{
                required: true,  
            }, 
            "instuctor[]":{
                required: true,  
            }, 
            // end_date:{
            //     greaterThan:'#start_date'
            // },
            // about:{
            //     required: function() {
            //         CKEDITOR.instances.aboutClass.updateElement();
            //     },
            // },
            // content:{
            //     required: function() {
            //         CKEDITOR.instances.classContent.updateElement();
            //     },  
            // }
        },
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'about') {                   
                error.insertAfter('#about');
            } else if(element.attr("name") == 'content'){ 
                error.insertAfter('#content');
            } else if(element.attr("name") == 'instuctor[]'){
                error.insertAfter('#instuctor');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            engagement_type: {
                required: 'Select engagement type',
            },
            engagement_mode:{
                required: 'Select engagement mode',
            }, 
             title: {
                required: 'Enter title',
            },
            short_description:{
                required: 'Enter short description',  
            },  
            price:{
                required: 'Enter price per month',  
            }, 
            about:{
                required: 'Enter about class',  
            }, 
            "instuctor[]":{
                required: 'Select instuctor',  
            }, 
            content:{
                required:"Enter contents of the class",
            },   
        }
    });

    $("#addCourse").validate({
        errorElement : 'div',
        rules: {
            course_type: {
                required: true,
            },
        },
        messages: {
            course_type: {
                required: 'Select course type',
            },
        }
    });

    $("#addInvoice").validate({
        errorElement : 'div',
        rules: {
            "data[]": {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
            
            if (element.attr("name") == 'data[]') {                   
                error.insertAfter('#particulars');
            } else { 
                error.insertAfter( element );
            }
        },
        messages: {
            "data[]": {
                required: 'Enter particulars',
            },
        }
    });
});
