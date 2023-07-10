@extends('layouts.user')
@section('title','User Batches')
@section('content')
<div class="right-detail">

	<div class="batchDetails">

		<div class="admin-page-header">
			<div class="top-header">
				<div class="title-wrapper">
					<a href="javascript:history.back()" class="page-heading-link hidden-xs" title=""><em><img
								src="{{ asset('front/images/back-arrow.svg') }}" alt=""></em></a>
					<h1 class="lg">{{ $batchDetails->title  }}</h1>
				</div>
				<div class="right-link">
					<ul>
						<li>
							<!-- <a href="javascript:void(0);" title="Search" class="showSearch">
								<img src="{{ asset('front/images/search.svg') }}" alt=""></a> -->
						</li>
						<li class="three-dot-wrapper dropdown show">
							<a href="#" title="" class="three-dots-link dropdown-toggle"
								id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
								aria-expanded="false"><img src="{{ asset('front/images/three-dot.svg') }}" alt=""></a>
							<div class="three-dot-menu dropdown-menu" aria-labelledby="dropdownMenuLink">
								<ul>
									<li>
										<a href="tel: 9998887770" title="Call us" class="border-block">Call 9998887770 for help</a>
									</li>
									<li>
										<a href="#" title="Leave batch" data-toggle="modal" data-target="#leaveBatchModal">Leave batch</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<ul class="partcipant-badge-list">
				<!-- <li>
					<em>
						<img src="{{ asset('front/images/users-gray.svg') }}" alt="">
					</em>
					{{ $batchDetails->students }} Participants
				</li> -->
				<li>
					<em>
						<img src="{{ asset('front/images/calendar-gray.svg') }}" alt="">
					</em>
					{{ date("d M", strtotime($batchDetails->start_date)) }} - {{ date("d M", strtotime($batchDetails->end_date)) }}
				</li>
				<li class="no-before">
					@if($batchDetails->engagement_mode == 1)
						<span class="tag sm">
							Studio {{ $batchDetails->engagement_type == 1 ? 'Batch' : 'Workshop' }}
						</span>
					@else 	
						<span class="tag green sm">
							Online {{ $batchDetails->engagement_type == 1 ? 'Batch' : 'Workshop' }}
						</span>
					@endif
				</li>
			</ul>
		</div>

		@if(is_null($checkAccess) || !is_null($checkAccess) && $checkAccess->status != 'PAID')
			@section('wrapper-class',' has-page-header empty-content-wrapper')
			<div class="admin-page-content">
				<div class="container">
					<div class="empty-content">
						<em><img src="{{ asset('front/images/empty-1.svg') }}" alt=""></em>
						<p>Please complete your payment first in order
							to get full access of this batch materials</p>
						<a href="{{ route('payment') }}" class="pink-btn filled" title="Continue Payment">Continue Payment</a>

					</div>
				</div>
			</div>
		@else

			@section('wrapper-class','has-page-header fix-tabbing-wrapper-mble')
			<div class="admin-page-content tabbing-wrapper">
				<div class="tabbing-link">
					<ul class="tabbing-list">
						<li><a href="#" title="Updates" class="active" data-link="update">Updates</a></li>
						<li><a href="#" title="Images" data-link="image">Images</a></li>
						<li><a href="#" title="Notes" data-link="note">Notes</a></li>
						<li><a href="#" title="Documents"  data-link="document">Documents</a></li>
					</ul>
				</div>
				<div class="tabbing-content">
					
					<div class="tabbing-outer active" data-content="update">
						<div class="update-list">
							@if(!is_null($course))
								@foreach($course as $bk => $bv)
									@if(!is_null($bv->course) && $bv->course->course_type == 1)
										<div class="update-list-item border-block">
											<div class="container">
												<p>{{ $bv->course->message }}</p>
												@if($bv->course->url !== '')
													<a href="{{ $bv->course->url }}" class="fancy-link">{{ $bv->course->url }}</a>
												@endif
											</div>
										</div>
									@endif
								@endforeach
							@endif
						</div>
					</div>

					<div class="tabbing-outer" data-content="image">
						<div class="gallery-page">
							<div class="container">
								<div class="row">
								@if(!is_null($course))
									@foreach($course as $bk => $bv)
										@if(!is_null($bv->course) && $bv->course->course_type == 2)
											@php $image =  Config::get('constants.awsUrl').'/course/'.$bv->course->course->uuid.'/images/'.$bv->course->file_name; @endphp

											<div class="col-lg-4 col-6">
												<div class="gallery-thumb-wrapper">
													<a href="{{ $image }}" class="html5lightbox" data-group="kb-img-gallery" title="{{ $image }}" style="background-image: url('{{ $image }}');">
													</a>
												</div>
											</div>
										@endif
									@endforeach
								@endif
								</div>
							</div>
						</div>
					</div>


					<div class="tabbing-outer" data-content="note">
						<div class="notes-grid">
						@if(!is_null($notes))
							@foreach($notes as $nk => $nv)
								<div class="grid-item notes_{{ $nv->id }}">
									<div class="grid-content">
										<h5>{{ \Illuminate\Support\Str::limit($nv->title, 35, $end='...')  }}</h5>
										<p>{{ \Illuminate\Support\Str::limit($nv->notes, 180, $end='...')  }}</p>
										<div class="grid-footer">
											<ul>
												<li> 
													<a href="javascript:void(0);" class="editNote editNoteForm" data-id="{{ $nv->id }}" title="Edit">Edit</a>
												</li>
												<li>
													<a href="javascript:void(0);" class="deleteNote" title="Delete" data-id="{{ $nv->id }}">Delete</a>
												</li>
											</ul>
											<span>{{ date('d-m-Y',strtotime($nv->created_at)) }}</span>
										</div>
									</div>
								</div>
							@endforeach
						@endif
						</div>
						<div class="bottom-link-wrapper">
							<a href="#" title="Add" class="addNewNote" data-id="{{ $batchDetails->id }}" data-uuid="{{ $batchDetails->uuid }}"><img src="{{ asset('front/images/plus-pink-bg.svg') }}" alt=""></a>
						</div>
					</div>

					<div class="tabbing-outer " data-content="document">
						<div class="document-list">
							@if(!is_null($course))
								@foreach($course as $bk => $bv)
									@if(!is_null($bv->course) && $bv->course->course_type == 3)
										@php $document =  Config::get('constants.awsUrl').'/course/'.$bv->course->course->uuid.'/document/'.$bv->course->file_name; @endphp
										<div class="document-list-item border-block">
											<div class="container">
												<p>
													<em><img src="{{ asset('front/images/pdf.svg') }}" alt=""></em>
													{{ $bv->course->title}}
												</p>
												<a href="{{ $document }}" class="upload-link" download>
													<img src="{{ asset('front/images/download-ic.svg') }}" alt="">
												</a>
											</div>
										</div>
									@endif
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
	@if(!is_null($checkAccess) && $checkAccess->status == 'PAID')
		<div class="searchdetails" style="display: none;">
			<div class="admin-page-header">
				<div class="top-header">
					<!-- <div class="title-wrapper">
						<div class="form-group secondary">
							<input type="text" class="form-control" placeholder="Search in this batch">
						</div>
					</div> -->
					<div class="right-link">
						<ul>
							<li>
								<a href="javascript:void(0);" title="Clear" class="clearSearch"><img src="{{ asset('front/images/cancel-gray.svg') }}" alt=""></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			@section('wrapper-class','has-page-header search-wrapper')
			<div class="admin-page-content">
				<div class="update-list">
					<div class="update-list-item border-block">
						<div class="container">
							<p>Basics of Kathak ipsum at, pellentesque viverra ex. Donec efficitur, sapien sed
								aliquet placerat, leo justo molestee vehicula fe giat nisi enim ac ante. Duis eu
								gravida ante. Aliquam auctor ligula sit amet accumsan ullamcorpe ornare nec
								ipsum sits.</p>
							<a href="#" class="fancy-link">rtmp://live.restream.io/live</a>
						</div>
					</div>
					<div class="update-list-item border-block">
						<div class="container">
							<p>Basics of Kathak ipsum sit amet varius. Pellentesque habitant morbi tristique
								senectus et netus et malesuada fames acturpi egestas.</p>
							<a href="#" class="fancy-link">rtmp://live.restream.io/live</a>
						</div>
					</div>

				</div>
				<div class="document-list">
					<div class="document-list-item border-block">
						<div class="container">
							<p><em><img src="{{ asset('front/images/pdf.svg') }}" alt=""></em>Sed hendrerit tortor a libero
								lobortis.pdf</p>
							<a href="#" class="upload-link"><img src="{{ asset('front/images/download-ic.svg') }}" alt=""></a>
						</div>
					</div>
					<div class="document-list-item">
						<div class="container">
							<p><em><img src="{{ asset('front/images/pdf.svg') }}" alt=""></em>Lorem ipsum, sem ac dignissim
								euismod.doc</p>
							<a href="#" class="upload-link"><img src="{{ asset('front/images/download-ic.svg') }}" alt=""></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	@endif
</div>
@endsection

