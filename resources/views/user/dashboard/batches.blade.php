@extends('layouts.user')
@section('title','User Batches')
@section('content')
@if(count($onlineBatches) > 0 || count($studioBatches) > 0)
@section('wrapper-class','has-page-header fix-tabbing-wrapper-mble')
	<div class="right-detail">
		
		<div class="admin-page-header  fix-tabbing-mble">
			<div class="tabbing-link">
				<ul class="tabbing-list">
					<li>
						<a href="#" @if(count($studioBatches) > 0) class="active" @endif title="Studio Batches" data-link="studio-batch">Studio Batches</a>
					</li>
					
					<li>
						<a href="#" title="Online Batches" @if(count($studioBatches) == 0 && count($onlineBatches) > 0) class="active" @endif data-link="online-batch">Online Batches</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="admin-page-content tabbing-content">
			@if(!is_null($studioBatches))
				<div class="tabbing-outer @if(count($studioBatches) > 0) active @endif" data-content="studio-batch">
					<div class="batch-list-grid">
						@foreach($studioBatches as $sbk => $sbv)
							<div class="bacth-list-item">
								<div class="container">
									<div class="image-block"
										style="background-image:url({{ Config::get('constants.awsUrl') }}/poster/{{ $sbv->poster }})">
									</div>
									<div class="content-block">
										<h4><a href="{{ route('batchDetails',$sbv->uuid) }}"
												title="Expressions That Matter In Kathak Dance Form">{{ $sbv->title }}</a></h4>
										<ul class="partcipant-badge-list">
											<!-- <li><em><img src="{{ asset('front/images/users-gray.svg') }}" alt=""></em>{{ $sbv->students }}
												Participants</li> -->
											<li>
												<em>
													<img src="{{ asset('front/images/calendar-gray.svg') }}" alt="">
												</em>{{ date("d-m-Y", strtotime($sbv->start_date)) }} to {{ date("d-m-Y", strtotime($sbv->end_date)) }}
											</li>
										</ul>
										<p>
											@php $student = \App\Models\WorkshopStudents::where('student_id',$userId)->where('workshop_id',$sbv->id)->first(); @endphp
											Sessions Attended : {{ $student->attanded_lecture }} out {{ $student->total_lecture }}
										</p>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endif

			@if(!is_null($onlineBatches))
				<div class="tabbing-outer @if(count($studioBatches) == 0 && count($onlineBatches) > 0) active @endif" data-content="online-batch" @if(count($studioBatches) == 0) style='display: block;' @endif>
					<div class="batch-list-grid">
						@foreach($onlineBatches as $obk => $obv)
							<div class="bacth-list-item">
								<div class="container">
									<div class="image-block"
										style="background-image:url({{ Config::get('constants.awsUrl') }}/poster/{{ $obv->poster }})">
									</div>
									<div class="content-block">
										<h4><a href="{{ route('batchDetails',$obv->uuid) }}"
												title="Expressions That Matter In Kathak Dance Form">{{ $obv->title }}</a></h4>
										<ul class="partcipant-badge-list">
											<!-- <li>
												<em>
													<img src="{{ asset('front/images/users-gray.svg') }}" alt="">
												</em>
												{{ $obv->students }} Participants
											</li> -->
											<li>
												<em>
													<img src="{{ asset('front/images/calendar-gray.svg') }}" alt="">
												</em>
												{{ date("d-m-Y", strtotime($obv->start_date)) }} to {{ date("d-m-Y", strtotime($obv->end_date)) }}
											</li>
										</ul>
										@php $student = \App\Models\WorkshopStudents::where('student_id',$userId)->where('workshop_id',$obv->id)->first(); @endphp
											Sessions Attended : {{ $student->attanded_lecture }} out {{ $student->total_lecture }}
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endif
		</div>
	</div>
@else
@section('empty','empty-content-wrapper')
	<div class="right-detail">
		<div class="admin-page-content">
			<div class="container">
				<div class="empty-content">
					<em><img src="{{ asset('front/images/empty-2.svg') }}" alt=""></em>
					<p>You have not registered in any batch yet!</p>
					<a href="{{ route('home') }}" class="pink-btn filled" title="Explore Batches">explore batches</a>

				</div>
			</div>

		</div>
	</div>
@endif

@endsection