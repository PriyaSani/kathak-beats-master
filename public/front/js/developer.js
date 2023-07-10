$(document).on('change','#country_id',function(){
    
    $.ajax({
        url:'/get-state-list',
        method:'post',
        data:{
            id : $(this).val(),
        },
        success: function(data){
            $('#state_id').remove();
            var html = '';
            html += '<select class="custom-dropdown sm secondary" name="state_id" id="state_id"><option value="">Select State</option>';
            $.each(data,function(key,value){
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });
            html += '</select>';

            $('#state').html(html);
            $('#state_id').dropkick({mobile:!0})
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
            $('#city_id').remove();
            var html = '';
            html += '<select class="custom-dropdown sm secondary" name="city_id" id="city_id"><option value="">Select City</option>';
            $.each(data,function(key,value){
                html += '<option value="'+value.id+'">'+value.name+'</option>';
            });
            html += '</select>';

            $('#city').html(html);
            $("#city_id").dropkick({mobile:!0})
        }
    });
});
