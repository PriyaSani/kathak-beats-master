$(document).on('click','.payNow',function(e){
    $('.remainigPayment').data('value',$(this).data('id'));
    $('#remianing-payment').modal('show');
});



$(document).on('click','.remainigPayment', function(e){

    var type = $(this).data('id');
    var invoice_id = $(this).data('value');
    var SITEURL = config.siturl;
    blockUi($('#remianing-payment'))
    $.ajax({
        type:'post',
        url:'/user/remaining-invoice-payment',
        data:{
            invoice_id : invoice_id,
            type:type
        },
        success: function(data){
            if(data.status != 500){
                unBlockUi($('#remianing-payment'))
                if(type == 'razorpay'){ 
                    $('#remianing-payment').modal('hide');

                    var options = {
                      	"key": config.razorpay_key,
                      	"amount": (data.price * 100),
                      	"currency": "INR",
                      	"name": "kathak Beats",
                      	"description": data.short_description,
                      	handler: function (response){
                            blockUi($('.right-detail'))
                            $.ajax({
                            	url : '/gateway/payment-success',
                            	method: 'post',
                            	data:{
                            		response : response,
                            		user_id : data.id,
                            		workshop_id : data.workshop_id,
                            		amount : data.price,
                            		invoice_id: invoice_id,
                            	},
                            	success: function(data){
                            		location.reload();
                            	}
                            });
                        },
                        "prefill": {
                			"name": data.name,
                			"email": data.email,
                			"contact": data.phone
                		},
                    };
                    var rzp1 = new Razorpay(options);
                  	rzp1.open();
                  	e.preventDefault();
                } else {
                    window.location.href = data.link;
                }
            } else {
                alert('Something went wrong');
            }
        }
    });
});

function invoiceFilter(type,start,end){

	$.ajax({
        url : '/user/invoice-filter',
    	method: 'post',
    	data:{
    		start_date : start,
    		end_date : end,
    		type : type,
    	},
    	success: function(data){
    		if(type == 'transaction'){
    			$('.paid-invoice-content').html(data)
    		} else {
    			$('.document-list').html(data)
    		}
    	}
    });
}

$(document).on('change','.startDate',function(e){
	invoiceFilter('transaction',$('.startDate').val(),$('.endDate').val())
})
$(document).on('change','.endDate',function(e){
	invoiceFilter('transaction',$('.startDate').val(),$('.endDate').val())
})
$(document).on('change','.inStart',function(e){
	invoiceFilter('invoice',$('.inStart').val(),$('.inEnd').val())
})
$(document).on('change','.inEnd',function(e){
	invoiceFilter('invoice',$('.inStart').val(),$('.inEnd').val())
})