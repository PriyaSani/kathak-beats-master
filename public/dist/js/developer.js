$.ajaxSetup({
	headers: {
	    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	}
});

$(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');  
});

$('#inputSMS').keyup(function(){
    if(this.value.length > 230){
        return false;
    }
    $("#remainingC").html("Remaining characters : " +(230 - this.value.length));
});

$('#shortDescription').keyup(function(){
    if(this.value.length > 150){
        return false;
    }
    $("#remainingC").html("Remaining characters : " +(150 - this.value.length));
});

$(document).on('keyup','#second',function(){
    if(this.value.length > 210){
        return false;
    }
    $("#remainingSecond").html("Remaining characters : " +(210 - this.value.length));
});

var drGalEvent = $('.dropifyGal').dropify();

$(document).on('change','.wpSameNo',function(){
    if($('#mobile').val() != ''){
        if ($(this).prop('checked')==true){ 
            $('#wp_number').val($('#mobile').val())
            $('#wp_number-error').remove();
            $('#wp_number').removeClass('error');
        } else {
            $('#wp_number').val('')
        }
    } else{
        toastr['error']('Enter mobile number first');
        $(this).prop('checked',false)
    }
});

var drVidEvent = $('.dropifyVid').dropify();

$(document).on('change','#grid_type_gallery',function(){
    if($(this).val() == 1){
        $('.grid-one').removeClass('hide');
        $('.hidePriority').removeClass('hide');
        $('.grid-two').addClass('hide');
        $('.gridOne').attr('required',true);
        $('.gridTwo').attr('required',false);
        $('.priority').val('');
        $(".dropify-clear").trigger("click");
    } else if($(this).val() == 2){
        $('.grid-two').removeClass('hide');
        $('.grid-one').addClass('hide');
        $('.gridOne').attr('required',false);
        $('.gridTwo').attr('required',true);
        $('.hidePriority').removeClass('hide');
        $('.priority').val('');
        $(".dropify-clear").trigger("click");
    } else {
        $('.grid-two').addClass('hide');
        $('.grid-one').addClass('hide');
        $('.hidePriority').addClass('hide');
        $('.gridOne').attr('required',false);
        $('.gridTwo').attr('required',false);
        $('.priority').val('');
        $(".dropify-clear").trigger("click");
    }
});

$(document).on('change','#grid_type',function(){
    if($(this).val() == 1){
        $('.priority').show();
        $('.grid-one').removeClass('hide');
        $('.grid-two').addClass('hide');
        $('.grid-three').addClass('hide');
        $('.gridOne').attr('required',true);
        $('.gridTwo').attr('required',false);
        $('.gridthree').attr('required',false);
        $(".dropify-clear").trigger("click");
    } else if($(this).val() == 2){
        $('.priority').show();
        $('.grid-two').removeClass('hide');
        $('.grid-one').addClass('hide');
        $('.grid-three').addClass('hide');
        $('.gridOne').attr('required',false);
        $('.gridtwo').attr('required',true);
        $('.gridthree').attr('required',false);
        $(".dropify-clear").trigger("click");
    } else if($(this).val() == 3){
        $('.priority').show();
        $('.grid-two').addClass('hide');
        $('.grid-one').addClass('hide');
        $('.grid-three').removeClass('hide');
        $('.gridOne').attr('required',false);
        $('.gridTwo').attr('required',false);
        $('.gridthree').attr('required',true);
        $(".dropify-clear").trigger("click");
    } else {
        $('.priority').hide();
        $('.grid-two').addClass('hide');
        $('.grid-one').addClass('hide');
        $('.grid-three').addClass('hide');
        $('.gridOne').attr('required',false);
        $('.gridTwo').attr('required',false);
        $('.gridthree').attr('required',false);
    }
    $('.indata').val('');
});




// //get auto suggest city
// $(document).on('keypress','.city',function(){
	
//     $.ajax({
//         url: "/get-city",
//         type: "POST",
//         dataType: "JSON",
//         success: function(data){
//             autocompletedatalist = data;
//             $('.city').autocomplete({ 
//                 source: autocompletedatalist,
//                 focus: function(event, ui) {
//                     event.preventDefault();
//                     this.value = ui.item.label;
//                 },
//                 select: function(event, ui) {
//                     event.preventDefault();
//                     $('.city').val(ui.item.label);
//                     $('#city_id').val(ui.item.value);
//                     return false;
//                 },
//             });
//         }
//     });
// });

// $(document).on('keypress','.state',function(){
	
//     $.ajax({
//         url: "/get-state",
//         type: "POST",
//         dataType: "JSON",
//         success: function(data){
//             autocompletedatalist = data;
//             $('.state').autocomplete({ 
//                 source: autocompletedatalist,
//                 focus: function(event, ui) {
//                     event.preventDefault();
//                     this.value = ui.item.label;
//                 },
//                 select: function(event, ui) {
//                     event.preventDefault();
//                     $('.state').val(ui.item.label);
//                     $('#state_id').val(ui.item.value);
//                     return false;
//                 },
//             });
//         }
//     });
// });

// $(document).on('keypress','.country',function(){
    
//     $.ajax({
//         url: "/get-country",
//         type: "POST",
//         dataType: "JSON",
//         success: function(data){
//             autocompletedatalist = data;
//             $('.country').autocomplete({ 
//                 source: autocompletedatalist,
//                 focus: function(event, ui) {
//                     event.preventDefault();
//                     this.value = ui.item.label;
//                 },
//                 select: function(event, ui) {
//                     event.preventDefault();
//                     $('.country').val(ui.item.label);
//                     $('#country_id').val(ui.item.value);
//                     return false;
//                 },
//             });
//         }
//     });
// });

$(document).on('change','#country_id',function(){
    
    $.ajax({
        url:'/get-state-list',
        method:'post',
        data:{
            id : $(this).val(),
        },
        success: function(data){
            var html = '';
            html += '<option value="">Select State</option>';
            $.each(data,function(key,value){
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });
            $('#state_id').html(html);
        }
    });
});


$(document).on('change','#state_id',function(){
    $.ajax({
        url:'/get-city-list',
        method:'post',
        data:{
            id : $(this).val(),
        },
        success: function(data){
            var html = '';
            html += '<option value="">Select City</option>';
            $.each(data,function(key,value){
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });
            $('#city_id').html(html);
        }
    });
});



$(document).on('change','.facultyStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/faculty/change-faculty-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Faculty status changed');
            }
        }
    });
});

$(document).on('change','.studentStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/student/change-student-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Student status changed');
            }
        }
    });
});

$(document).on('change','.changeWorkshopStudent',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/batch/change-workshop-student-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Student status changed');
            }
        }
    });
});

$(document).on('change','.changeInquiryStatus',function(){
    $.ajax({
        url: "/kb-backend/inquiry/change-inquiry-status",
        type: "POST",
        data:{ status: $(this).val(),id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Inquiry status changed');
            }
        }
    });
});

$(document).on('change','.studio',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/studio/change-studio-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Studio status changed');
            }
        }
    });
});

$(document).on('change','.galleryStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/cms/change-gallery-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Gallery image status changed');
            }
        }
    });
});

$(document).on('change','.videoStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/cms/change-video-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Video status changed');
            }
        }
    });
});

$(document).on('change','.changeUpdateStatus',function(){
    var id = $(this).data('id');
    var option = '';

    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }

    $.ajax({
        url: "/kb-backend/batch/change-update-status",
        type: "POST",
        data:{ id:id,option:option},
        success: function(data){
            if(data){
               toastr['success']('Status changed');
            }
        }
    });
});

$(document).on('click','.unlinkCourse',function(){
    var id = $(this).data('id');
    var value = $(this).data('value');
    var content = $(this).data('content');

    if(confirm('Do you want to unlink this content from this engagement?')){
        $.ajax({
            url: "/kb-backend/course/remove-image-update",
            type: "POST",
            data:{ id:id,value:value,content:content},
            success: function(data){
                if(data){
                    if(value == 'document'){
                        $('.table_row_'+id).remove();
                        $('#table_id_003').DataTable();
                    } else {
                        $('.image_'+id).remove();
                    }
                }
            }
        });
    }
});



$(document).on('change','.courseStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/course/change-course-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Course status changed');
            }
        }
    });
});

$(document).on('click','.addVideo',function(e){
    e.preventDefault();
    var cPos = $(this).data('id');
    if(cPos <= 4){
        var html = '<tr class="video_'+cPos+'"><td class="border"> <input type="text" name="video['+cPos+'][title]" class="form-control" required></td><td class="border"> <input type="file" name="video['+cPos+'][thumb]" id="video['+cPos+'][thumb]" class="dropify" data-max-file-size="5M" required></td><td class="border"> <input type="url" name="video['+cPos+'][url]" class="form-control" required></td><td class="border"> <input type="text" name="video['+cPos+'][priority]" class="form-control numeric"></td><td class="border"><input name="video['+cPos+'][status]" class="form-check-switch form-control ml-auto" checked="checked" type="checkbox" ></td><td class="border"> <span style="cursor:pointer;" class="removeDiv btn btn-danger" data-id="'+cPos+'">X</span></td></tr>';
        $('.video_row').append(html);
        $('.dropify').dropify();
        cPos++;
        $('.addVideo').data('id',cPos);
        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g,'');  
        });
    } else {
        alert('Only 5 videos are allowed');
    }
});

$(document).on('click','.removeDiv',function(){
    var cPos = $(this).data('id');
    $('.video_'+cPos).remove();
    var mCount = $('.addVideo').data('id');
    mCount--;
    $('.addVideo').data('id',mCount);
})

$(document).on('submit','#addWork',function(e){
    e.preventDefault();
    if($('.addVideo').data('id') == 0){
        toastr['error']('Please add atleast one video');
    } else{
        $('#addWork')[0].submit();
    }
});

/***************************** Batch and workshop code ****************************************/

$(document).on('click','.button-apply',function(){
    if($('#engagement_type').val() == 2){
        var daterange = $('.daterange').val().split("-");
        const date1 = new Date(covertIntoLogicalDate(daterange[0].trim()));
        const date2 = new Date(covertIntoLogicalDate(daterange[1].trim()));
        var diffDays = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10); 
        $('.workshop-table').show();
        $('.workshop-tbody').empty();
        $('.batch-table').hide();
        $('.batch-tbody').empty();
        for(var i = 0;i <= diffDays; i++){
            date = date1;
            date = date.setDate(date.getDate() + 1);
            var html = '<tr><td class="border"><input type="checkbox" name="data['+i+'][select_date]" class="workshop_range" data-id="'+i+'" /></td><td class="border">'+(parseInt(i) + parseInt(1))+'</td><td class="border"><input type="text" name="data['+i+'][date]" class="form-control" value="'+getFormattedDate(date1.toISOString().substr(0, 10))+'" readonly /></td><td class="border"><input type="time" name="data['+i+'][start_time]" class="form-control  start_time_'+i+'"  data-id="'+i+'" readonly></td><td class="border"><input type="time" name="data['+i+'][end_time]" class="form-control time end_time_'+i+'" data-id="'+i+'" readonly></td></tr>';
            $('.workshop-tbody').append(html);
        }
    } 
});

$(document).on('change','#frequency',function(){
    if($('#engagement_type').val() == 1){
        var frequency = $('#frequency').val();
        $('.batch-table').show();
        $('.batch-tbody').empty();
        $('.workshop-table').hide();
        $('.workshop-tbody').empty();

        for(var i = 0;i < frequency; i++){
            var html = '<tr><td class="border">'+(parseInt(i) + parseInt(1))+'</td><td class="border"><select class="form-control menulist daySelection select'+i+'" name="data['+i+'][day]" data-id="'+i+'" required><option value="1">Sunday</option><option value="2">Monday</option><option value="3">Tuesday</option><option value="4">Wednesday</option><option value="5">Thrusday</option><option value="6">Friday</option><option value="7">Saturday</option></select></td><td class="border"><input type="time" name="data['+i+'][start_time]" class="form-control  start_time_'+i+'"  data-id="'+i+'" required></td><td class="border"><input type="time" name="data['+i+'][end_time]" class="form-control time end_time_'+i+'" data-id="'+i+'" required></td></tr>';        
            $('.batch-tbody').append(html);
        }
    }
});

$(document).on('change','.workshop_range',function(){
    var id = $(this).data('id');
    if(this.checked){
        $('.start_time_'+id).attr('readonly',false);
        $('.start_time_'+id).attr('required',true);
        $('.end_time_'+id).attr('readonly',false);
        $('.end_time_'+id).attr('required',true);
    } else {
        $('.start_time_'+id).attr('readonly',true);
        $('.start_time_'+id).attr('required',false);
        $('.end_time_'+id).attr('readonly',true);
        $('.end_time_'+id).attr('required',false);
    }

})
// $(document).on('change','.daySelection',function(){
//     var current_id = $(this).data('id');
//     var current_val = $(this).val();

//     var selectArray = [];



//     $('.daySelection').each(function( index ) {
//         var id = $(this).data('id');
//         if(current_id !== id){
//             $(".select"+id+" option[value='" + current_val + "']").attr("disabled",false);
//             $(".select"+id+" option[value='" + current_val + "']").attr("disabled","disabled");
//         }
//     }); 
// });

$(document).on('change','#engagement_mode',function(){
    if($(this).val() == 1){
        $('.studio_batch').show();
        $('.studio_batch').attr('required',true);
    } else {
        $('.studio_batch').hide();
        $('.studio_batch').attr('required',false);
    }
});


$(document).on('change','#engagement_type',function(){
    if($(this).val() == 1){
        $('.workshop').hide();
        $('.batch').show();
        $('.batch').attr('required',true);
    } else {
        $('.batch').hide();
        $('.workshop').show();
        $('.batch').attr('required',false);
    }
    $('.workshop-table').hide();
    $('.workshop-tbody').empty();
    $('.batch-table').hide();
    $('.batch-tbody').empty();
});

function covertIntoLogicalDate(date){
    var date = date.split('/');
    var date = date[1]+"/"+date[0]+"/"+date[2];
    return date;
}

function getFormattedDate(date) {
    var date = date.split('-');
    return date[2] + "/" + date[1] + "/" + date[0];
}

$(document).on('change','.batchStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/batch/change-workshop-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Batch\'s status changed');
            }
        }
    });
});

$(document).on('change','.updateStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/batch/change-update-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Update\'s status changed');
            }
        }
    });
});




$(document).on('change','.bookingStatus',function(){
    if(this.checked){
        option = 1;
    } else {
        option = 0;
    }
    $.ajax({
        url: "/kb-backend/batch/change-booking-status",
        type: "POST",
        data:{ option: option,id:$(this).data('id')},
        success: function(data){
            if(data){
               toastr['success']('Booking status changed');
            }
        }
    });
});


/***************************** Batch and workshop code ****************************************/

$(document).on('change','#course_type',function(){
    var course_type = $(this).val();
    if(course_type == 1){
        $('.update').removeClass('hide');
        $('.image').addClass('hide');
        $('.document').addClass('hide');
    } else if(course_type == 2){
        $('.update').addClass('hide');
        $('.image').removeClass('hide');
        $('.document').addClass('hide');
    } else if(course_type == 3){
        $('.update').addClass('hide');
        $('.image').addClass('hide');
        $('.document').removeClass('hide');
    }
})

var i = 0;

$(document).on('click','#addUpdate',function(){


    var html = '<div class="grid grid-cols-12 gap-2 mt-5 addUpdate"><input type="text" class="form-control col-span-4" placeholder="Update Message" aria-label="default input inline 1" name="data['+i+'][message]" required data-msg="Enter update"><input type="url" class="form-control col-span-4" placeholder="URL" name="data['+i+'][url]" aria-label="default input inline 2"><a class="btn btn-primary w-30 mr-1 mb-2 mt-4 removeUpdateRow" href="javascript:void(0);">x</a></div>';

    i++;

    $('#updatePreview').append(html);
});

$(document).on('click','.removeUpdateRow',function(){
    $(this).closest('.addUpdate').remove();
})


$(document).on('click','#addDocument',function(){

    var html = '<div class="grid grid-cols-12 gap-2 addDocument"><input type="text" class="form-control col-span-4" placeholder="Title" aria-label="default input inline 1" style="height: 50px;" name="data['+i+'][title]" ><input type="file" class="form-control col-span-4 " placeholder="Input inline 2" name="data['+i+'][document]" aria-label="default input inline 2" data-allowed-file-extensions="pdf docx rtf"><a class="btn btn-primary w-30 mr-1 mb-2 removeDocumentRow" href="javascript:void(0);">x</a></div><br>';
    i++;
    $('#documentPreview').append(html);
    $('.dropify').dropify();
});

$(document).on('click','.removeDocumentRow',function(){
    $(this).closest('.addDocument').remove();
})

$(document).on('click','.unlinkFaculty',function(){
    
    var workshop_id = $(this).data('id');
    var faculty_id = $(this).data('value');

    $.ajax({
        url: "/kb-backend/faculty/unlink-faculty",
        type: "POST",
        data:{ workshop_id: workshop_id,id:faculty_id},
        success: function(data){
            if(data.removed){
               toastr['success']('Faculty Unlinked');
               $('#row_'+workshop_id).remove();
            } else {
               toastr['error']('Please add other faculty to unlink this faculty.');
            }
        }
    });
});


// CKEDITOR.replace('aboutClass', {
//     wordcount: {
//         'showWordCount': false,
//         'showParagraphs': false,
//         'showCharCount': true,
//         'maxCharCount': 550
//     }
// });

// CKEDITOR.replace('classContent', {
//     wordcount: {
//         'showWordCount': false,
//         'showParagraphs': false,
//         'showCharCount': true,
//         'maxCharCount': 1400
//     }
// });

//start date and end time
$(document).on('change','.time',function(){
    var id = $(this).data('id');
    var dtStart = new Date("1/1/2011 " + $('.start_time_'+id).val());
    var dtEnd = new Date("1/1/2011 " + $('.end_time_'+id).val());
    var difference_in_milliseconds = dtEnd - dtStart;
    if (difference_in_milliseconds < 0){
        toastr['error']('End time is greater than to start time!');
        $('.end_time_'+id).val('');
    }
})
 
$(document).on('change','#start_date',function(){
    $.ajax({
        url: "/kb-backend/batch/update-date",
        type: "POST",
        data:{ date: $(this).val()},
        success: function(data){
            $('#end_date').val(data);
        }
    });
});

$(document).on('click','.unlinkWorkshop',function(){
    var id = $(this).data('id');
    $.ajax({
        url: "/kb-backend/student/unlink-work-shop",
        type: "POST",
        data:{ id: id},
        success: function(data){
            $('.workshop_'+id).remove();
        }
    });
});

$(document).on('click','.unlinkUser',function(){
    var id = $(this).data('id');
    $.ajax({
        url: "/kb-backend/batch/unlink-student",
        type: "POST",
        data:{ id: id},
        success: function(data){
            $('#row_'+id).remove();
        }
    });
});

//get auto suggest city
$(document).on('keypress','#student',function(){
    
    $.ajax({
        url: "/kb-backend/invoice/get-student",
        type: "POST",
        dataType: "JSON",
        success: function(data){
            autocompletedatalist = data;
            $('#student').autocomplete({ 
                source: autocompletedatalist,
                focus: function(event, ui) {
                    event.preventDefault();
                    this.value = ui.item.label;
                },
                select: function(event, ui) {
                    event.preventDefault();
                    $('#student').val(ui.item.label);
                    $('#student_id').val(ui.item.value);
                    $.ajax({
                        url: "/kb-backend/invoice/get-student-details",
                        type: "POST",
                        data:{ id: ui.item.value},
                        success: function(data){
                            $('#student').val(data.name);
                            $('#student_id').val(data.id);
                            $('#name').val(data.name)
                            $('#address').val(data.address)
                            $('#phone_number').val(data.contact_number)
                            $('#city').val(data.city.name)
                            $('#state').val(data.state.name)
                            $('#country').val(data.country.name)
                        }
                    });
                },
            });
        }
    });
});

$(document).on('change','#invoice_payment_cycle',function(){
    if($(this).val() == 'MONTHLY'){
        $('.inqty').val(1);
        $('.monthly').show();
        $('.quartely').hide();
    } else if($(this).val() == 'QUARTERLY'){
        $('.inqty').val(3);
        $('.monthly').hide();
        $('.quartely').show();
    } else {
        $('.inqty').val('');
        $('.monthly').hide();
        $('.quartely').hide();
    }
});

$(document).on('change','.inBatch',function(){
    $('.inTitle').val($("select.inBatch option:selected").text());
});

// Remove error message of instructor in add workshop page
$(document).on('change','#selectInstructor', function(){
    var instructor = $("#selectInstructor").val();
    if(instructor !== undefined && instructor != ''){
        $('#selectInstructor-error').text('');
    }
});