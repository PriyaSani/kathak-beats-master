<!DOCTYPE html>
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/logo/favicon.ico') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Kathak beats">
        <meta name="keywords" content="Kathak beats">
        <title>@yield('title') | Kathak Beats</title>
        <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
        <link rel="stylesheet" href="{{ asset('dist/css/developer.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    </head>
    <!-- END: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                   
                    <div class="my-auto">
                        <img alt="Midone Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-18" src="{{ asset('dist/images/logo/logo.png') }}">
                    </div>
                </div>
                <!-- END: Login Info -->
                @yield('content')
            </div>
        </div>
        <!-- BEGIN: JS Assets-->
        <script src="{{ asset('dist/js/app.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="{{ asset('dist/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('dist/js/validation.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- END: JS Assets-->
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
