@extends('layouts.user')
@section('title','User Batches')
@section('content')
@section('wrapper-class','admin-dashboard-wrapper has-page-header')
<div class="right-detail">
	<div class="admin-page-header hidden-xs">
		<div class="title-wrapper">
			<a href="javascript:history.back()" class="page-heading-link" title="Back">
				<em><img src="{{ asset('front/images/back-arrow.svg') }}" alt=""></em>
			</a>
			@if($details->engagement_type == 1)
				@if($details->engagement_mode == 1)
					<h1>Studio Batches</h1>
				@else
					<h1>Online Batches</h1>
				@endif
			@else
				@if($details->engagement_mode == 1)
					<h1>Studio Workshop</h1>
				@else
					<h1>Online Workshop</h1>
				@endif
			@endif
			
		</div>
	</div>
	<div class="admin-page-content">
		<section class="batch-highlight-info">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 ">
						<div class="batch-banner">
							@php $poster = Config::get('constants.awsUrl').'/poster/'.$details->poster; @endphp
							<div class="inner-banner"
								style="background-image: url('{{ $poster }}');"></div>
						</div>
					</div>
					<div class="col-lg-6 batch-content">
						<h3>{{ $details->title }}</h3>
						<ul class="participants-detail">
							<!-- <li><em><img src="{{ asset('front/images/users-gray.svg') }}" alt=""></em>{{ $details->students }} Participants
							</li> -->
							<li>
								@if($details->engagement_type == 1)
									@if($details->engagement_mode == 1)
										<span class="tag green">Studio Batch</span>
									@else
										<span class="tag yellow">Online Batch</span>
									@endif
								@else
									@if($details->engagement_mode == 1)
										<span class="tag green">Studio Workshop</span>
									@else
										<span class="tag yellow">Online Workshop</span>
									@endif
								@endif
							</li>
						</ul>
						<div class="instructor-wrapper">
							<div class="instructor-img-wrapper">
								@foreach($faculty as $f)
									<em style="background-image: url('{{ $f }}');"></em>
								@endforeach
							</div>
							{{ implode(', ',$name) }} (Instructor(s))</div>
							{!! $details->description !!}
						<div class="price-wrapper">
							<h3 class="price">₹{{ $details->price }}/- <span style="font-size: 10px;color:#fc9898">(*Taxes applicable)</span></h3>
							@if($details->engagement_type == 1)
								@if($details->engagement_mode == 2)
									<a href="javascript:void(0);" class="yellow-btn register filled" data-id="{{ base64_encode($details->id) }}" data-title title="Register">Register</a>
								@endif
							@else
								<a href="javascript:void(0);" class="yellow-btn register filled" data-id="{{ base64_encode($details->id) }}" data-title title="Register">Register</a>
							@endif

						</div>
						@if($details->engagement_type == 1)
							@if($details->engagement_mode == 1)
								<br /><span>Please contact to admin or instructor(s) in offline for registration</span>
							@endif
						@endif
					</div>

				</div>
			</div>
		</section>
		<section class="batch-detailed-info">
			<div class="container">
				<div class="inner-info">
					<h4>About class</h4>
					{!! $details->about !!}
				</div>
			</div>
		</section>
		<section class="batch-detailed-info">
			<div class="container">

				<div class="inner-info">
					<h4>Contents of the class</h4>
					{!! $details->content !!}
				</div>

			</div>
		</section>
	</div>
</div>

@endsection
