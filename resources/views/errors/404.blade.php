@extends('layouts.utility')
@section('title','404 | Page Not Found')
@section('content')
<div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
    <div class="-intro-x lg:mr-20">
        <img alt="Midone Tailwind HTML Admin Template" class="h-48 lg:h-auto" src="{{ asset('dist/images/error-illustration.svg') }}">
    </div>
    <div class="text-white mt-10 lg:mt-0">
        <div class="intro-x text-8xl font-medium">404</div>
        <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Oops. This page has gone missing.</div>
        <div class="intro-x text-lg mt-3">You may have mistyped the address or the page may have moved.</div>
        <a href="{{ route('index') }}" class="intro-x btn py-3 px-4 text-white border-white dark:border-dark-5 dark:text-gray-300 mt-10">Back to Home</a>
    </div>
</div>
@endsection