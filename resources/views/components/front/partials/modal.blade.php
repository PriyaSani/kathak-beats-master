<!-- Login modal starts -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content" id="login-modal-content">
			<a href="#" class="modal-close" title="Close" data-dismiss="modal"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<div class="login-wrapper">
				<h4>Welcome!</h4>
				<p>Please enter your email id to login</p>
				<form method="post" id="loginForm">
					<div class="form-group emailLogin">
						<input type="email" class="form-control sm emailLoginInput" placeholder="Enter your email" name="email" required autocomplete="off" >
					</div>
					<div class="blockOtp"></div>
					<button type="submit" class="yellow-btn filled">Verify</button>
				</form>
				Don't have an account? <a href="javascript:voide(0);" class="signupmodal">Sign up</a>
			</div>
		</div>
	</div>
</div>
<!-- Login modal ends -->

<!-- Signup modal starts -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered lg">
		<div class="modal-content" id="signup-modal-content">
			<a href="#" class="modal-close" title="Close" data-dismiss="modal"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<div class="login-wrapper full-width">
				
				<h4>Join Us</h4>
				<p>And be a part of our exciting workshop and classes</p>
				<form method="post" id="signup" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="form-group file-upload">
								<input type="file" name="profile" onchange="loadFile(event)">
								<em><img src="{{ asset('front/images/user-lg.svg') }}" alt=""  id="output"></em>
								<span id="uploadPhoto">Upload photo</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" class="form-control sm" name="name" placeholder="Full name*" required autocomplete="off" >
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="email" class="form-control sm" name="email" placeholder="Email Id*" required autocomplete="off" >
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group tel">
								<input type="tel" class="form-control numeric sm" id="telephone"  placeholder="Contact number" value="" name="contact_number" required>
								<span id="contactNumber"></span>
							</div>
							
						</div>
						<div class="col-md-6">
							<div class="form-group tel">
								<input type="tel" class="form-control numeric sm" id="whatsappContact" placeholder="WhatsApp number" name="whatsapp_contact" required>
								<span id="whatsappNumber"></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group custom-date-picker">
								<input type="text" class="form-control sm datepicker" name="dob" placeholder="Date of birth*" required autocomplete="off" >
							</div>
						</div>
						@php $country = \App\Models\Country::all(); @endphp
						<div class="col-md-6">
							<div class="form-group">
								<select class="custom-dropdown sm" name="country" id="country" required>
									<option selected disabled class="placeholder">Country*</option>
									@if(!is_null($country))
										@foreach($country as $ck => $cv)
											<option value="{{ $cv->id }}">{{ $cv->name }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group state">
								<select class="custom-dropdown sm" name="state" id="state" required>
									<option selected disabled class="placeholder">State*</option>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group city">
								<select class="custom-dropdown sm" name="city" id="city" required>
									<option selected disabled class="placeholder">City*</option>
								</select>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" class="form-control sm" name="address" placeholder="Full Address" required autocomplete="off" >
							</div>
						</div>
					</div>
					<div class="btn-block">
						 <button type="submit" class="yellow-btn filled">Sign up</button>
					</div>
				</form>
				Have an account? <a href="javascript:void(0);" class="loginModal">Sign in</a>
			</div>
		</div>
	</div>
</div>
<!-- Signup modal ends -->

<!-- OTP modal starts -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content" id="otp-modal-content">
			<a href="#" class="modal-close" title="Close" data-dismiss="modal"><img src="{{ asset('front/images/close.svg') }}" alt=""></a>
			<div class="login-wrapper">
				<h4>Enter OTP</h4>
				<p>OTP sent to <span id="otp_email" class="otpEmail"></span></p>
				<form method="post" id="otpForm" >
					<input type="hidden" name="email" value="" class="otpEmail" />
					<div class="form-group otp-inputs">
						<input type="number" class="form-control inputs" name="otp[]" placeholder="-" maxlength="1" tabindex="1" required autocomplete="off">
						<input type="number" class="form-control inputs" name="otp[]" placeholder="-" maxlength="1" tabindex="2" required>
						<input type="number" class="form-control inputs" name="otp[]" placeholder="-" maxlength="1" tabindex="3" required>
						<input type="number" class="form-control inputs" name="otp[]" placeholder="-" maxlength="1" tabindex="4" required>
					</div>
					<span class="errorOtp"></span>
					<span class="timer" id="timer">01:00</span>
					<span class="hide timer" id="resendOtp">Resend OTP</span>
					<button type="submit" class="yellow-btn filled">Verify</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- OTP modal ends -->

<div class="modal fade " id="openModal" role="dialog">
    <div class="modal-dialog modal-lg" role="document" >
       <div class="modal-content">
            <div class="modal-header" style="border-bottom: none !important;">
                <h2>Link</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>                        
            </div>
                <div class="modal-body modal-spa " id="linkDetails">
                </div>
        </div>
     </div>
</div>

