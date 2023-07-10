<script src="{{ asset('front/js/vendor.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" ></script>
<script src="{{ asset('front/js/blockui.js') }}"></script>
<script src="{{ asset('front/js/batch_details.js') }}"></script>
<script src="{{ asset('front/js/config.js') }}"></script>
<script src="{{ asset('front/js/developer.js') }}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">

	$(document).on('click','.leaveBatchModal',function(){
		$('#leaveWorkshopBatch').val($(this).data('id'));
		$('#leaveBatchModal').modal('toggle');
	});

	$(document).on('click','.leaveWokshopBatch',function(){
		var workshop_id = $('#leaveWorkshopBatch').val();
		$.ajax({
			url:'/user/leave-batch',
			method:'post',
	        data: {
	        	workshop_id : workshop_id
	        },
			success: function(data){
				if(data.status == 'true'){
					$('#leaveBatchModal').modal('toggle');
					window.location.href = "https://kathakbeats.in/home";
				}
			}
		});
	});

	$(document).on('click','.notificationClear',function(){
		$.ajax({
			url:'/user/clear-notification',
			method:'post',
			success: function(data){
				location.reload();
			}
		});
	});

	$(document).on('click','.clearSearch',function(){
		$('.searchdetails').hide();
		$('.batchDetails').show();
		$('.admin-dashboard-wrapper').removeClass('search-wrapper').addClass('fix-tabbing-wrapper-mble');
		$('.fix-tabbing-wrapper-mble').css('padding-top','120px');
	});

	$(document).on('click','.showSearch',function(){
		$('.searchdetails').show();
		$('.batchDetails').hide();
		$('.admin-dashboard-wrapper').removeClass('fix-tabbing-wrapper-mble').addClass('search-wrapper');
		$('.search-wrapper').css('padding-top','78px');
	});
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
</script>

@if(route::is('payment'))
	<script src="{{ asset('front/js/payment.js')}}"></script>
@endif

@if(route::is('onlineBatchDetails'))
	<script src="{{ asset('front/js/online_batch_details.js')}}"></script>
@endif