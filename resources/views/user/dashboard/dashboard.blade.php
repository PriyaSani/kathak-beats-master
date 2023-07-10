@extends('layouts.user')
@section('title','User Dashboard')
@section('content')

<div class="right-detail">

	@if(count($getOnlineBatch) > 0)
	<section class="dashboard-batch-slider">
		<div class="container">
			<h2>Online Batches</h2>
			<div class="batch-slider swiper-container">
				<div class="swiper-wrapper">
					@foreach($getOnlineBatch as $wk => $wv)
						<div class="swiper-slide batch-slide">
							@php $poster =Config::get('constants.awsUrl').'/poster/'.$wv->poster; @endphp
							<div class="batch-thumb"
								style="background-image: url('{{ $poster }}');"></div>
							<div class="batch-info">
								<h5>{{ $wv->title }}</h5>
								<!-- <p class="participants">{{ $wv->students }} Participants</p> -->
								<a href="{{ route('onlineBatchDetails',$wv->uuid) }}" class="fancy-link learn-more-link" title="Learn More">Learn
									More</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
	@endif

	@if(count($getStudioBatch) > 0)
	<section class="dashboard-batch-slider">
		<div class="container">
			<h2>Studio Batches</h2>
			<div class="batch-slider swiper-container">
				<div class="swiper-wrapper">
					@foreach($getStudioBatch as $wk => $wv)
						<div class="swiper-slide batch-slide">
							@php $poster =Config::get('constants.awsUrl').'/poster/'.$wv->poster; @endphp
							<div class="batch-thumb"
								style="background-image: url({{ $poster }});"></div>
							<div class="batch-info">
								<h5>{{ $wv->title }}</h5>
								<!-- <p class="participants">{{ $wv->students }} Participants</p> -->
								<a href="{{ route('onlineBatchDetails',$wv->uuid) }}" class="fancy-link learn-more-link" title="Learn More">Learn
									More</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
	@endif

	@if(count($getWorkshop) > 0)
	<section class="dashboard-batch-slider">
		<div class="container">
			<h2>Online workshops</h2>
			<div class="batch-slider swiper-container">
				<div class="swiper-wrapper">
					@foreach($getWorkshop as $wk => $wv)
						<div class="swiper-slide batch-slide">
							@php $poster =Config::get('constants.awsUrl').'/poster/'.$wv->poster; @endphp
							<div class="batch-thumb"
								style="background-image: url({{ $poster }});"></div>
							<div class="batch-info">
								<h5>{{ $wv->title }}</h5>
								<!-- <p class="participants">{{ $wv->students }} Participants</p> -->
								<a href="{{ route('onlineBatchDetails',$wv->uuid) }}" class="fancy-link learn-more-link" title="Learn More">Learn
									More</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</section>
	@endif

	@if($isFirstRegister == 1)
		<!-- thankyou modal starts -->
		<div class="modal fade thankyou-modal" id="thankyouModal"  tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content has-white-bg">
					<a href="#" class="modal-close" title="Close" data-dismiss="modal"><svg xmlns="http://www.w3.org/2000/svg" width="17.138" height="17.142" viewBox="0 0 17.138 17.142">
						<path id="letter-x" d="M.243,1.43a.854.854,0,0,1,0-1.189.854.854,0,0,1,1.189,0L8.567,7.388,15.713.241A.836.836,0,1,1,16.89,1.43L9.756,8.566l7.135,7.147A.836.836,0,0,1,15.713,16.9L8.567,9.754,1.432,16.9a.854.854,0,0,1-1.189,0,.854.854,0,0,1,0-1.189L7.378,8.566Z" transform="translate(-0.002 0)" fill="#fff"/>
					  </svg>
					  </a>
					<div class="thankyou-wrapper">
						<h4>Thank you for registration!</h4>
						<em>
							<img src="{{ asset('front/images/smile-emoji.svg') }}" alt="smile">
						</em>
						<p>You can now access all the details
							from your dashboard</p>
					</div>
				</div>
			</div>
		</div>
		<!-- thankyou modal ends -->
	@endif

</div>

@endsection



