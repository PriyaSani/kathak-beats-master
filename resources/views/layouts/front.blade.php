<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>@yield('title')</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="title" content="@yield('title')" />
		<meta name="description" content="@yield('description')" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Kathak Beats" />
		<meta property="og:url" content="https://kathakbeats.in" />
		

		<meta property="og:image" content="http://kb-portal.fltstaging.com/dist/images/share_logo.png">
		<meta property="og:site_name" content="Kathak Beats" />
		<meta name="twitter:card" content="summary_large_image" />
	    <meta name="twitter:site" content="@kathakbeats" />
	    <meta name="twitter:title" content="Kathak Beats" />

	    <meta property="og:description" content="KathakBeats is a Classical Dance Academy which offers Regular Training, Workshops and other modules of training in KATHAK in both online and studio class modes for all the dance enthusiasts.">
	    <meta name="twitter:description" content="KathakBeats is a Classical Dance Academy which offers Regular Training, Workshops and other modules of training in KATHAK in both online and studio class modes for all the dance enthusiasts." />

	    <meta name="twitter:image" content="http://kb-portal.fltstaging.com/dist/images/share_logo.png" />

		@include('components.front.partials.header_link')
	</head>
	<body>
		<div class="wrapper">
			@include('components.front.partials.header')
			@yield('content')
		</div>
		@include('components.front.partials.footer')
		@include('components.front.partials.footer_link')
		@include('components.front.partials.modal')
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