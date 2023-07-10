@extends('layouts.user')
@section('title','Notifications')
@section('content')
@section('wrapper-class','admin-dashboard-wrapper has-page-header')
<div class="right-detail">
	<div class="admin-page-header hidden-xs">
		<div class="top-header">
			<div class="title-wrapper">
				<a href="javascript:history.back()" class="page-heading-link hidden-xs" title="Back">
					<em>
						<img src="{{ asset('front/images/back-arrow.svg') }}" alt="">
					</em>
				</a>
				<h1>My Notifications</h1>
			</div>
			<div class="right-link">
				<ul>
					@if(count($notification) > 0)
						<li>
							<a href="javascript:void(0);" title="Clear all" class="notificationClear">Clear all</a>
						</li>
					@endif
				</ul>
			</div>
		</div>

	</div>
	<div class="admin-page-content">
		@if(!is_null($notification))
			@foreach($notification as $nk => $nv)
				<div class="notification-content border-block">
					<div class="container">
						<p>
							{{ $nv->notification }}

							<span>{{ $nv->created_at->diffForHumans() }}</span>
						</p>
					</div>
				</div>
			@endforeach
		@endif 
	</div>
</div>

@endsection
