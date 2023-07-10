@extends('layouts.front')
@section('title','Get in Touch with KathakBeats')
@section('description','Get in Touch with Team KathakBeats for Collaborations, Regular or Online Batch Inquiry, we are happy to get in touch with you!')
@section('content')
<main>
	<section class="contact-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="contact-form">
						<h2 class="no-border">Contact Us</h2>
						<p>For classes and workshops Enquiry</p>
						<form method="post" action="{{ route('saveContactInquiry') }}" id="contactForm">
							@csrf
							<input type="hidden" name="recaptcha" id="recaptcha">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" class="form-control" name="full_name" placeholder="Full name" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="email" class="form-control" name="email" placeholder="Email Id" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group tel">
										<input type="tel" class="form-control numeric" id="telephone" name="contact_number" minlength="10" maxlength="10" placeholder="Contact number" value="" required>
										<span id="contactNumber"></span>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group tel">
										<input type="tel" class="form-control numeric" id="whatsappContact" name="whatsapp_number"  placeholder="WhatsApp number" required>
										<span id="whatsappNumber"></span>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<select class="custom-dropdown sm" name="purpose" required>
											<option selected disabled class="placeholder">Select purpose for reaching out*</option>
											<option value="Collaborations">Collaborations</option>
											<option value="Regular Batch Enquiry">Regular Batch Enquiry</option>
											<option value="Upcoming Workshop Enquiry">Upcoming Workshop Enquiry</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<textarea class="form-control" name="address" placeholder="Your message"></textarea>
									</div>
								</div>
							</div>
							<button type="submit" class="yellow-btn">Submit</button>
						</form>
					</div>
				</div>
				<div class="col-lg-3 offset-lg-1">
					<div class="contact-info">
						<div class="inner-info">
							<h4>Address</h4>
							<p>
								The Desi Art Studio <br>
								Gala No 23, Building No 2, <br>
								Sainath Industrial Estate, <br>
								Vishveshwar Nagar Rd, <br>
								Opp. Pravasi Ind Estate, <br>
								Goregaon-East, Mumbai, <br>
								Maharashtra 400063
								
							</p>
						</div>
						<div class="inner-info">
							<h4>For Collaboration</h4>
							<ul>
								<li>
									<a href="mailto:sanika@kathakbeats.in">sanika@kathakbeats.in</a>
								</li>
								<li>
									<a href="mailto:siddharth@kathakbeats.in">siddharth@kathakbeats.in</a>
								</li>
							</ul>
						</div>
						<div class="inner-info">
							<h4>For Enquiry</h4>
							<ul>
								<li>
									<a href="mailto:contact@kathakbeats.in">contact@kathakbeats.in</a>
								</li>
								<li>
									<a href="tel:+91 9998887770">+91 8169270103</a>
								</li>
							</ul>
						</div>
						<ul class="social-icons">
							<li><a href="https://youtube.com/channel/UCKByDSEbOFftIQTBi54DGew" title="Youtube" target="_blank"><img src="{{ asset('front/images/youtube.svg') }}" alt=""></a></li>
							<li><a href="https://www.facebook.com/DancewithSanikaPurohit/" title="Facebook" target="_blank"><img src="{{ asset('front/images/facebook.svg') }}" alt=""></a></li>
							<li><a href="https://www.instagram.com/kathakbeats/?igshid=1xltn4f2p6pge" title="Instagram" target="_blank"><img src="{{ asset('front/images/instagram.svg') }}" alt=""></a></li>
						</ul>
						<!-- <a href="#" class="fancy-link" title="Download Our Brochure">Download Our Brochure</a> -->
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection