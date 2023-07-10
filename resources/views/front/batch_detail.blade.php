@extends('layouts.front')
@section('title','Batch Detail')
@section('content')
<main>
	<section class="batch-highlight-info">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 batch-content">
					<h3>{{ $batch->title }}</h3>
					<ul class="participants-detail">
						<!-- <li><em><img src="public/images/users.svg" alt=""></em>{{ $batch->students }} Participants</li> -->
						<li>
							@if($batch->engagement_mode == 1)
								<span class="tag yellow">Studio Batch</span>
							@else
								<span class="tag green">Online Batch</span>
							@endif
						</li>
					</ul>
					<p>{{ $batch->description }}</p>
					<h3 class="price">₹{{$batch->price}}/- <sub style="font-size: 10px;color:#fc9898">(*Taxes applicable)</sub></h3>
					@if($batch->engagement_mode == 1 && $batch->engagement_type == 1)
						<a href="{{ route('contactUs') }}" class="yellow-btn filled" title="Contact Us" >Contact Us</a>
					@else
						@if(Auth::user())
							<a href="{{ route('onlineBatchDetails',$uuid) }}" class="yellow-btn filled" title="Register">Register</a>
						@else
							<a href="javascript:void(0);" class="yellow-btn filled registerForBatch" title="Register" data-id="{{ $uuid }}">Register</a>
						@endif
					@endif

				</div>
				<div class="col-lg-6 offset-lg-1 batch-banner">
					@php $image = $batch->poster ?  Config::get('constants.awsUrl').'/poster/'.$batch->poster : ''; @endphp
					<div class="inner-banner" style="background-image: url('{{ $image }}');"></div>
				</div>
			</div>
		</div>
	</section>

	<section class="batch-detailed-info">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 left-details">
					<div class="inner-info">
						<h4>About class</h4>
						{!! $batch->about !!}
					</div>

					<div class="inner-info">
						<h4>Contents of the class</h4>
						{!! $batch->content !!}
					</div>
				</div>
				@if(!is_null($batch->workshopfaculty))
					<div class="col-lg-4 col-xl-3 offset-xl-1 right-details">
						<div class="author-info">
							<div class="author-wrapper">
							<p>Instructors</p>
							<div class="author-dp-wrapper">
								@php $name= array();@endphp
								@foreach($batch->workshopfaculty as $wk => $wv)
									@php 
										$image = !is_null($wv->faculty) ? Config::get('constants.awsUrl').'/profile/'.$wv->faculty->profile_image : '';
										$name[] = $wv->faculty->name;
									@endphp

									<div class="author-dp" style="background-image: url('{{ $image }}');"></div>
								@endforeach
							</div>
							</div>
							<div class="author-details">
								<h4> {{ implode(', ',$name) }} </h4>

							</div>
						</div>
					</div>
				@endif
			</div>
			
		</div>
	</section>
</main>
@endsection