$(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');  
});

$(document).on('keyup',".inputs",function () {
    if (this.value.length == this.maxLength) {
      $(this).next('.inputs').focus();
    }
});

$(document).on('keyup',".inputs",function(event) {
	if (event.originalEvent.keyCode === 8) {
		$(this).prev('.inputs').focus();
	}
});

let timerOn = true;

function timer(remaining) {
  	
  	var m = Math.floor(remaining / 60);
  	var s = remaining % 60;

		m = m < 10 ? '0' + m : m;
		s = s < 10 ? '0' + s : s;
		
		document.getElementById('timer').innerHTML = m + ':' + s;
		remaining -= 1;

		if(remaining >= 0 && timerOn) {
		setTimeout(function() {
    		timer(remaining);
		}, 1000);
		return;
		}

		if(!timerOn) {
		return;
		}

		$('#resendOtp').show();
		$('#timer').hide();
}

//Signup modal
$(document).on('submit','#signup',function(e){
	e.preventDefault();
	blockUi($('#signup-modal-content'))
	$('.signupmodal').attr('disabled',true)
	$.ajax({
		url:'/auth/signup',
		method:'post',
		dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
		success: function(data){
			if(data.status == 'success'){
				unBlockUi($('#signup-modal-content'))
				$('.signupmodal').attr('disabled',false)
				$('#signupModal').modal('toggle');
				$('#otpModal').modal('toggle');
				timer(90)
				$('.otpEmail').val(data.email);
				$('.otpEmail').text(data.email);
			} else {
				unBlockUi($('#signup-modal-content'))
				$('#signupModal').modal('hide');
			}
		}
	});
});

//Otp Form
$(document).on('submit','#otpForm',function(e){
	e.preventDefault();
	blockUi($('#otp-modal-content'))
	$.ajax({
		url:'/auth/verify-otp',
		method:'post',
		dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
		success: function(data){
			if(data.status == 'success'){
				unBlockUi($('#otp-modal-content'))
				window.location.href = config.loginurl
			} else {
				unBlockUi($('#otp-modal-content'))
				$('.errorOtp').text('Invalid OTP!');
			}
		}
	});
});

//login form
$(document).on('submit','#loginForm',function(e){
	e.preventDefault();
	blockUi($('#login-modal-content'))
	$.ajax({
		url:'/auth/authentication',
		method:'post',
		dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
		success: function(data){
			if(data.status == 'success'){
				unBlockUi($('#login-modal-content'))
				$('#loginModal').modal('toggle');
				$('#otpModal').modal('toggle');
				$('#resendOtp').hide()
				timer(90)
				$('.otpEmail').val(data.email);
				$('.otpEmail').text(data.email);
			} else {
				unBlockUi($('#login-modal-content'))
				$('.blockOtp').append('<span class="emailBlock">'+data.message+'</span><br><br>');
			}
		}
	});
});

//Resend OTP
$(document).on('click','#resendOtp',function(e){
	blockUi($('#otp-modal-content'))
	$('#resendOtp').hide();
		$('#timer').show();
		timer(90)
	$.ajax({
		url:'/auth/resend-otp',
		method:'post',
		dataType: "JSON",
        data: new FormData($('#otpForm')[0]),
        processData: false,
        contentType: false,
		success: function(data){
			if(data.status == 'success'){
				unBlockUi($('#otp-modal-content'))
				timer(90)
			} 
		}
	});
});

//load File Function
var loadFile = function(event) {
	var output = document.getElementById('output');
   	output.src = URL.createObjectURL(event.target.files[0]);
   	$('#uploadPhoto').remove();
    $('#output').css({"width": "70px","height":"70px",'border-radius':'35px'})
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
};

//login modal call 
$(document).on('click','.loginModal',function(){
	$('#signupModal').modal('toggle');
	$('#loginModal').modal('toggle');
	setTimeout(modalOpenClass,400)
});

//signup modal
$(document).on('click','.signupmodal',function(){
	$('#loginModal').modal('toggle');
	$('#signupModal').modal('toggle');
	setTimeout(modalOpenClass,400)
});

function modalOpenClass(){
	$('body').addClass('modal-open');
}

//resitesr batch
$(document).on('click','.registerForBatch',function(){
	var id = $(this).data('id')
	$.ajax({
		url:'/save-workshop-batch-details',
		method:'post',
		data:{
			id : id,
		},
		success: function(data){
			if(data){
				$('#signupModal').modal('show');
			}
		}
	});
})


$(document).on('change','#country',function(){

	var id = $(this).val();

	$.ajax({
		url:'/get-state-list',
		method:'post',
		data:{
			id : id,
		},
		success: function(data){
			$('#state').remove();
			var html = '';
			html += '<select class="custom-dropdown sm" name="state" id="state" required><option selected disabled class="placeholder">State*</option>';
			$.each(data,function(key,value){
				html += '<option value="'+value.id+'">'+value.name+'</option>';
			});
			html += '</select>';
			console.log(html)
			$('.state').html(html)
			$('#state').dropkick()
		}
	});
})


$(document).on('change','#state',function(){

	var id = $(this).val();

	$.ajax({
		url:'/get-city-list',
		method:'post',
		data:{
			id : id,
		},
		success: function(data){
			$('#city').remove();
			var html = '';
			html += '<select class="custom-dropdown sm" name="city" id="city" required><option selected disabled class="placeholder">City*</option>';
			$.each(data,function(key,value){
				html += '<option value="'+value.id+'">'+value.name+'</option>';
			});
			html += '</select>';
			console.log(html)
			$('.city').html(html)
			$('#city').dropkick()
		}
	});
})


