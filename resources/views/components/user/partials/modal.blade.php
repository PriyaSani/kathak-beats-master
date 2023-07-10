<!-- <div class="modal fade thankyou-modal" id="thankyouModal"  tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content has-white-bg">
			<a href="#" class="modal-close" title="Close" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="17.138" height="17.142" viewBox="0 0 17.138 17.142">
				<path id="letter-x" d="M.243,1.43a.854.854,0,0,1,0-1.189.854.854,0,0,1,1.189,0L8.567,7.388,15.713.241A.836.836,0,1,1,16.89,1.43L9.756,8.566l7.135,7.147A.836.836,0,0,1,15.713,16.9L8.567,9.754,1.432,16.9a.854.854,0,0,1-1.189,0,.854.854,0,0,1,0-1.189L7.378,8.566Z" transform="translate(-0.002 0)" fill="#fff"/>
			  </svg>
			  </a>
			<div class="thankyou-wrapper">
				<h4>Thank you for registration!</h4>
				<em>
					<img src="{{ asset('/front/images/smile-emoji.svg') }}" alt="smile">
				</em>
				<p>You can now access all the details
					from your dashboard</p>
			</div>
		</div>
	</div>
</div>

 -->
<div class="modal fade" id="payment-modal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog sm-width create-sip-modal modal-dialog-centered">
		<div class="modal-content" style="border-radius: 1.5rem;background:#ffffff">
			<div class="modal-pop" style="text-align: center;">
				<h5 style="color: #972330;">Choose payment option</h5>
			</div>
			<a href="#" class="modal-close" data-bs-dismiss="modal">
				<img src="{{ asset('dist/images/ic-cross-white.svg') }}" data-dismiss="modal" aria-label="Close" alt="">
			</a>
			<div class="modal-body" style="margin-top:10px;">
				<div class="form-wrapper">
					<ul>
						
						<li style="cursor: pointer;color:#727272" class="payment" data-id="razorpay" data-value="">RazorPay (For Indian Residents Only)</li>
						<hr />
						<li style="cursor: pointer;color:#190404" class="payment" data-id="paypal" data-value="">PayPal  (For Non Indian Residents Only)</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="remianing-payment" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog sm-width create-sip-modal modal-dialog-centered">
		<div class="modal-content" style="border-radius: 1.5rem;background:#ffffff">
			<div class="modal-pop" style="text-align: center;">
				<h5 style="color: #972330;">Choose payment option</h5>
			</div>
			<a href="#" class="modal-close" data-bs-dismiss="modal">
				<img src="{{ asset('dist/images/ic-cross-white.svg') }}" data-dismiss="modal" aria-label="Close" alt="">
			</a>
			<div class="modal-body" style="margin-top:10px;">
				<div class="form-wrapper">
					<ul>
						
						<li style="cursor: pointer;color:#727272" class="remainigPayment" data-id="razorpay" data-value="">RazorPay (For Indian Residents Only)</li>
						<hr />
						<li style="cursor: pointer;color:#190404" class="remainigPayment" data-id="paypal" data-value="">PayPal  (For Non Indian Residents Only)</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>