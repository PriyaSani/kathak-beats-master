<script src="{{ asset('front/js/vendor.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script src="{{ asset('front/js/blockui.js') }}"></script>
<script src="{{ asset('dist/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('front/js/validation.js') }}"></script>
<script src="{{ asset('front/js/config.js') }}"></script>
<script src="{{ asset('front/js/auth.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" ></script>

<script src="https://www.google.com/recaptcha/api.js?render=6LdRPtsdAAAAANFHqWKmtUnyq72gJhnBOWlUG3JN"></script>
<script>
grecaptcha.ready(function() {
     grecaptcha.execute('6LdRPtsdAAAAANFHqWKmtUnyq72gJhnBOWlUG3JN', {action: 'contact'}).then(function(token) {
        if (token) {
          document.getElementById('recaptcha').value = token;
        }
     });
});
</script>
