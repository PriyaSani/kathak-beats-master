$(document).on('click','.register',function(e){
	$('.payment').data('value',$(this).data('id'));
	$('#payment-modal').modal('show');
});


$(document).on('click','.payment',function(e){
	var type = $(this).data('id');
	var workshop_id = $(this).data('value');
	var SITEURL = config.siturl;
	blockUi($('#payment-modal'))
	$.ajax({
		type:'post',
		url:'/user/enroll-batch',
		data:{
			workshop_id : workshop_id,
			type:type
		},
		success: function(data){
			unBlockUi($('#payment-modal'))
			if(type == 'razorpay'){	
				$('#payment-modal').modal('hide');
				var name = data.name;
		      	var phone = data.phone;
		      	var email = data.email;
		      	var user_id = data.id;
		        var totalAmount = data.price;
		        var description =  data.workshop_name;

		        var options = {
		          	"key": config.razorpay_key,
		          	"amount": (totalAmount * 100),
		          	"currency": "INR",
		          	"name": "kathak Beats",
		          	"description": description,
		          	handler: function (response){
		          		blockUi($('.right-detail'))
		                $.ajax({
		                	url : '/gateway/payment-success',
		                	method: 'post',
		                	data:{
		                		response : response,
		                		user_id : user_id,
		                		workshop_id : workshop_id,
		                		amount : totalAmount,
		                		invoice_id : data.invoice_id,
		                	},
		                	success: function(data){
		                		window.location.href = SITEURL+'user/batches-list';
		                	}
		                });
		            },
		            "prefill": {
						"name": name,
						"email": email,
						"contact": phone
					},
		        };
		        var rzp1 = new Razorpay(options);
		      	rzp1.open();
		      	e.preventDefault();
			} else {
				window.location.href = data.link;
			}
		}
	});
});
