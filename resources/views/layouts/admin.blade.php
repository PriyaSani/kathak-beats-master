<!DOCTYPE html>
<html lang="en" class="light">
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/logo/favicon.ico') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Kathak Beats">
        <meta name="keywords" content="Kathak Beats">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <title>@yield('title') | Kathak Beats</title>

        @include('components.admin.partials.header_link')

    </head>

    <body class="main">
       <x-admin-mobile-sidebar />
 
       <div class="flex">
            <x-admin-sidebar :module=$module />
            <div class="content">
                <x-admin-topnavigation />
                @yield('content')
            </div>
        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key=["your-google-map-api"]&libraries=places"></script>
        @include('components.admin.partials.footer_link')
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