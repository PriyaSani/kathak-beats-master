$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var config = {
	siturl: window.location.origin,
	loginurl: window.location.origin+'/home',
	otpTimer:90,
	resendTimeOut:600000,
	//razorpay_key : 'rzp_test_X6T2aZNj2pMj0h',
	razorpay_key : 'rzp_live_vS9h88M8j6DSm9'
};
