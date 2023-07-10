<header>
	<div class="container">
		<a href="{{ route('index') }}" class="logo" title="Kathak Beats"><img src="{{ asset('front/images/logo.png') }}" alt=""></a>
		<nav>
			<ul>
				<li class="has-submenu">
					<a href="{{ route('about') }}" title="About Us">About Us </a>
					<span class="submenu-arrow"></span>
					<ul class="submenu ">
						<li><a href="{{ route('about') }}#kathakbeats" title="Kathak Beats">Kathak Beats</a></li>
						<li><a href="{{ route('about') }}#about-team" title="About Team">About Team</a></li>
					</ul>
				</li>
				<li><a href="{{ route('index') }}#kalabhumi" title="kalabhumi">Kalabhoomi</a></li>
				<!-- <li><a href="{{ route('about') }}" title="Associations">About Us</a></li> -->
				<li><a href="{{ route('index') }}#association" title="Associations">Associations</a></li>
				<li><a href="{{ route('index') }}#batches-gallery" title="Batches">Batches</a></li>
				<li><a href="{{ route('index') }}#batches-gallery" title="Gallery">Gallery</a></li>
				<li><a href="{{ route('contactUs') }}" title="Contact">Contact</a></li>
			</ul>
		</nav>
		@auth
			<a href="{{ route('home') }}" class="secondary-link is-logged-in">Hi, {{ Auth::user()->name }}</a>
		@else
			<a href="#" title="Sign in" class="secondary-link" data-toggle="modal" data-target="#loginModal">Sign in</a>
		@endauth
			
		<div class="hamburger-menu">
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
</header>