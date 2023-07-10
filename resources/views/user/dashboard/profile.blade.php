@extends('layouts.user')
@section('title','User Profile')
@section('content')
@section('wrapper-class','has-page-header fix-tabbing-wrapper-mble')
<div class="right-detail">
	<div class="admin-page-header fix-tabbing-mble">
		<div class="tabbing-link">
			<ul class="tabbing-list">
				<li>
					<a href="#" title="My General Details" class="active" data-link="general-detail">
						My General Details
					</a>
				</li>
				<li>
					<a href="#" title="My Attendance" data-link="attendance">
						My Attendance
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="admin-page-content tabbing-content ">
		<div class="tabbing-outer active" data-content="general-detail">
			<form method="post" id="profileForm" enctype="multipart/form-data">
				<div class="general-detail-block">
					<div class="container top-block">
						<div class="user-img-wrapper">
							@if($userProfile->profile_image != '')
								<div class="user-img">
									<img src="{{ Config::get('constants.awsUrl') }}/student/{{ $userProfile->profile_image }}" id="user-img" style="border-radius:50%;height:100%">
								</div> 
							@else
								<div class="user-img">
									<img src="https://kathakbeats.in/dist/images/logo/logo.png" id="user-img" style="border-radius:50%;height:100%">
								</div> 
							
							@endif
							<div class="file-upload">
								<input type="file" name="profile_image" id="profile_image" onchange="loadFile(event)">
								<a href="#" title="Upload Photo" class="fancy-link">Upload Photo</a>
							</div>
						</div>
						<div class="edit-link-wrapper">
							<a href="#" class="edit-detail pink-btn editProfile" title="Edit Details">Edit Details</a>
							<button class="update-detail pink-btn updateProfile" title="Save Details" type="submit">
								Save Details
							</button>
						</div>

					</div>
					<ul>
						<li class="border-block">
							<div class="container">
								<h6>Full name</h6>
								<p class="name">{{ $userProfile->name }}</p>
								<div class="form-group secondary">
									<input type="text" name="name" id="name" value="{{ $userProfile->name }}" class="form-control">
								</div>
							</div>
						</li>
						<li class="border-block">
							<div class="container">
								<h6>Email id</h6>
								<p class="email">{{ $userProfile->email }}</p>
								<div class="form-group secondary">
									<input type="text" name="email" id="email" value="{{ $userProfile->email }}" class="form-control">
								</div>
							</div>
						</li>
						<li class="border-block">
							<div class="container">
								<h6>Contact no.</h6>
								<p class="contact_number">{{ $userProfile->contact_number }}</p>
								<div class="form-group tel secondary">
									<input type="tel" name="contact_number" class="form-control sm" id="contact_number" placeholder="Contact number" value="{{ $userProfile->contact_number }}">
								</div>
							</div>
						</li>
						<li class="border-block">
							<div class="container">
								<h6>WhatsApp no.</h6>
								<p class="wp_number">{{ $userProfile->wp_number }}</p>
								<div class="form-group tel secondary">
									<input type="tel" name="wp_number" class="form-control sm" id="wp_number" placeholder="WhatsApp number" value="{{ $userProfile->wp_number }}">
								</div>
							</div>
						</li>
						<li class="border-block">
							<div class="container">
								<h6>Date of birth</h6>
								<p class="dob"> {{ date("d-m-Y", strtotime($userProfile->dob)) }}</p>
								<div class="form-group custom-date-picker secondary">
									<input type="text" name="dob" id="dob" class="form-control sm datepicker"
										Value="{{ date("d-m-Y", strtotime($userProfile->dob)) }}">	
								</div>

							</div>
						</li>
						<li class="border-block">
							<div class="container">
								<h6>Payment mode</h6>
								<p class="mode">{{ $userProfile->billing_cycle }} &nbsp;&nbsp;<img src="{{ asset('front/images/1176.png') }}" alt="info" style="width: 2%;" data-toggle="tooltip" title="Please contact system admin to change your billing cycle from monthly to quarterly or vice versa.." /></p>
								<div class="form-group">
									<p name="mode" id="mode">{{ $userProfile->billing_cycle }} </p> 
								</div>

							</div>
						</li>
						<li class="border-block">
							<div class="container">
								<h6>Country</h6>
								<p class="country_name">{{ $userProfile->country->name }}</p>
								<div class="form-group">
									<select class="custom-dropdown sm secondary" name="country_id" id="country_id">
										<option value="">Select country</option>
										@if(!is_null($country))
											@foreach($country as $cok => $cov)
												<option @if($userProfile->country_id == $cov->id) selected @endif value="{{ $cov->id }}" data-id="{{ $cov->id }}">
													{{ $cov->name }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
						</li>

						@php $state = \App\Models\State::where('country_id',$userProfile->country_id)->get(); @endphp

						<li class="border-block">
							<div class="container">
								<h6>State</h6>
								<p class="state_name">{{ $userProfile->state->name }}</p>
								<div class="form-group" id="state">
									<select class="custom-dropdown sm secondary" name="state_id" id="state_id" required>
										<option value="">Select state</option>
										@if(!is_null($state))
											@foreach($state as $cok => $cov)
												<option @if($userProfile->state_id == $cov->id) selected @endif value="{{ $cov->id }}" data-id="{{ $cov->id }}">
													{{ $cov->name }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
						</li>

						@php $city = \App\Models\City::where('state_id',$userProfile->state_id)->get(); @endphp
						<li class="border-block">
							<div class="container">
								<h6>City</h6>
								<p class="city_name">{{ !is_null($userProfile->city) ? $userProfile->city->name  : ""}}</p>
								<div class="form-group" id="city">
									<select class="custom-dropdown sm secondary" name="city_id" id="city_id" required>
										<option value="">Select city</option>
										@if(!is_null($city))
											@foreach($city as $ck => $cv)
												<option @if(!is_null($userProfile->city) && $userProfile->city->id == $cv->id) selected @endif value="{{ $cv->id }}" data-key="{{ $cv->id }}">
													{{ $cv->name }}
												</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
						</li>
						<li>
							<div class="container">
								<h6>Your Address</h6>
								<p class="address">{{ $userProfile->address }}</p>
								<div class="form-group secondary">
									<input type="text" name="address" id="address" class="form-control"
										value="{{ $userProfile->address }}">
								</div>
							</div>
						</li>

					</ul>

				</div>
			
			</form>
		</div>

		<div class="tabbing-outer tabbing-wrapper" data-content="attendance">
			<div class="tabbing-link secondary">
				<ul class="tabbing-list">
					<li><a href="#" title="Online Batch" class="active" data-link="online-batch">Online Batch</a></li>
					<li><a href="#" title="Studio Batch"  data-link="studio-batch">Studio Batch</a></li>
				</ul>
			</div>
			<div class="tabbing-content ">
				<div class="tabbing-outer active" data-content="online-batch">
					<div class="custom-table-outer">
						<div class="custom-table-heading border-block">
							<div class="container">
								<h5 class="large">Batch Name</h5>
								<h5>Attended Sessions</h5>
								<h5>Conducted Sessions</h5>
							</div>
						</div>
						@if(!is_null($getStudentWorkshop))
							@foreach($getStudentWorkshop as $sk => $sv)
								@if(!is_null($sv->workshop))
									@if($sv->workshop->engagement_type == 1 && $sv->workshop->engagement_mode == 2) 
										<div class="custom-table-content border-block">
											<div class="container">
												<h6>{{ $sv->workshop->title }}</h5>
												<p>{{ $sv->attanded_lecture }}</p>
												<p class="black-text">{{ $sv->total_lecture }}</p>
											</div>
										</div>
									@endif
								@endif
							@endforeach
						@endif
					</div>
				</div>
				<div class="tabbing-outer" data-content="studio-batch">
					<div class="custom-table-outer">
						<div class="custom-table-heading border-block">
							<div class="container">
								<h5 class="large">Batch Name</h5>
								<h5>Attended Sessions</h5>
								<h5>Conducted Sessions</h5>
							</div>
						</div>
						@if(!is_null($getStudentWorkshop))
							@foreach($getStudentWorkshop as $sk => $sv)
								@if(!is_null($sv->workshop))
									@if($sv->workshop->engagement_type == 1 && $sv->workshop->engagement_mode == 1) 
										<div class="custom-table-content border-block">
											<div class="container">
												<h6>{{ $sv->workshop->title}}</h5>
												<p>{{ $sv->attanded_lecture }}</p>
												<p class="black-text">{{ $sv->total_lecture }}</p>
											</div>
										</div>
									@endif
								@endif
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	var loadFile = function(event) {
		var output = document.getElementById('user-img');
	   	output.src = URL.createObjectURL(event.target.files[0]);
	    output.onload = function() {
	      URL.revokeObjectURL(output.src) // free memory
	    }
	};

    $(document).on('click','.updateProfile',function(e){
    	e.preventDefault();
	    $.ajax({
	        type: 'post',
	        url: '/user/update-profile',
	       	processData: false,
			contentType: false,
	        data: new FormData(document.getElementById("profileForm")),
	        success: function(data) {
	        	if(data != 'false'){
		            $('.name').html(data.name);
		            $('.email').html(data.email);
		            $('.contact_number').html(data.contact_number);
		            $('.wp_number').html(data.wp_number);
		            $('.dob').html(data.dob);
		            $('.country_name').html(data.country.name);
		            $('.state_name').html(data.state.name);
		            $('.city_name').html(data.city.name);
		            $('.address').html(data.address);             
		        }
	        }
	    });
	}); 
</script>
@endsection