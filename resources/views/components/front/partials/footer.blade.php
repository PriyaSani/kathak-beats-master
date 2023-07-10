<footer>
	<div class="top-footer">
		<div class="container">
			<a href="#" class="logo" title="Kathak Beats"><img src="{{ asset('front/images/logo.png') }}" alt=""></a>
			<ul class="footer-menu">
				<li><a href="{{ route('about') }}" title="About">About</a></li>
				<li><a href="{{ route('index') }}#association" title="Associations">Associations</a></li>
				<li><a href="{{ route('refundPolicy') }}" title="Associations" target="_blank">Refund Policy</a></li>
				<li><a href="{{ route('contactUs') }}" title="Contact">Contact</a></li>
				<!-- <li><a href="#" title="Download Our Brochure">Download <span>Our</span> Brochure</a></li> -->
			</ul>
			<ul class="social-icons">
				<li>
					<a href="https://youtube.com/channel/UCKByDSEbOFftIQTBi54DGew" title="Youtube" target="_blank"><em><img src="{{ asset('front/images/youtube.svg') }}" alt=""></em></a>
				</li>
				<li>
					<a href="https://www.facebook.com/DancewithSanikaPurohit/" title="Facebook" target="_blank"><em><img src="{{ asset('front/images/facebook.svg') }}" alt=""></em></a>
				</li>
				<li>
					<a href="https://www.instagram.com/kathakbeats/?igshid=1xltn4f2p6pge" title="Instagram" target="_blank"><em><img src="{{ asset('front/images/instagram.svg') }}" alt=""></em></a>
				</li>
			</ul>
		</div>
	</div>
	<div class="bottom-footer">
		<div class="container">
			<p>© {{ date('Y') }} KATHAK BEATS EDUTAINMENT LLP
				<a href="{{ route('termsAndConditions') }}" target="_blank" style="color: #543a3a;"> 
					&nbsp;&nbsp;&nbsp;Terms & Conditions 
				</a> 
				<a href="{{ route('privacyPolicy') }}" target="_blank" style="color: #543a3a;"> 
					&nbsp;&nbsp;&nbsp;Privacy Policy
				</a>
			</p>
		</div>
	</div>
</footer>