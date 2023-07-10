@extends('layouts.login')
@section('title','User Login')
@section('content')
<!-- BEGIN: Login Form -->
<div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
            Sign In
        </h2>
        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account.</div>

        <form class="form-horizontal" action="{{ route('user.postlogin') }}" id="loginForm" method="post">
            @csrf
            <div class="intro-x mt-8">
                
                <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Email" name="email" required>

                <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" name="password" placeholder="Password" required>
            </div>

            <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4" style="float: right;">
                <a href="{{ route('user.auth.password.reset') }}" class="mb-4">Forgot Password?</a> 
            </div>
            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Login Form -->
@endsection  
