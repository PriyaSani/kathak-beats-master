<!DOCTYPE html>
<html lang="en-US">

	<head>
		<meta charset="utf-8">
		<title>@yield('title') | Kathak Beats</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="csrf-token" name="_token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<link rel="shortcut icon" href="{{ asset('front/images/favicon.ico') }}" />

		@include('components.user.partials.header_link')
	</head>

	<body class="@if(route::is('batchDetails')) light-box-has-download @endif admin-panel">

		<div class="wrapper admin-dashboard-wrapper @yield('wrapper-class')">
			<main>
				<div class="admin-wrapper @if(route::is('notifications')) notification-wrapper @elseif(route::is('payment')) tabbing-wrapper payment-page @elseif(route::is('batches') || route::is('studentWorkshop')) tabbing-wrapper  @elseif(route::is('profile')) tabbing-wrapper my-profile-wrapper @else batch-detail-wrapper  my-profile-wrapper  @endif @yield('empty')">
					<x-user-sidebar />
					@include('components.user.partials.header')
					@yield('content')

					@include('components.user.partials.modal')

					@if(route::is('batchDetails'))
						@include('components.user.partials.batch_details_modal')
					@endif
				</div>
			</main>
		</div>
		@include('components.user.partials.footer_link')
		@yield('js')
	</body>

</html>
<script type="text/javascript">
    @if(Session::has('messages'))
        $(document).ready(function() {
            @foreach(Session::get('messages') AS $msg) 
                toastr['{{ $msg["type"] }}']('{{$msg["message"]}}');
            @endforeach
        });
    @endif

    @if (count($errors) > 0) 
        $(document).ready(function() {
            @foreach($errors->all() AS $error)
                toastr['error']('{{$error}}');
            @endforeach     
        });
    @endif
</script>