@extends('layouts.login')
@section('title','Forgot Password')
@section('content')
<div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
        @if (session('status'))
            <div class="rounded-md px-5 py-4 mb-2 bg-theme-9 text-white" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
            Forgot Password
        </h2>
        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
       
        <form class="needs-validation form-horizontal" action="{{ route('admin.passwordemail') }}" method="post" id="forgotForm">
            @csrf
            <div class="intro-x mt-8">
                <input type="email" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Email" name="email" required>
            </div>
           
            <div class="intro-x mt-3 xl:mt-3 text-center xl:text-left">
                <button class="btn btn-primary py-3 px-4 w-full xl:w-40 xl:mr-4 align-top">Reset Password</button>
            </div>
            <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                <div class="flex items-center mr-auto">
                    <!-- <input type="checkbox" class="input border mr-2" id="remember-me">
                    <label class="cursor-pointer select-none" for="remember-me">Remember me</label> -->
                </div>
                <a href="{{ route('admin.login') }}">Back to login</a>
            </div>
        </form>
    </div>
</div>
@endsection  
