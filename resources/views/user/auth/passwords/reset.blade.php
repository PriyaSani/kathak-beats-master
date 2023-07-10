@extends('layouts.login')
@section('title','Reset Password')
@section('content')
<div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
    <div class="my-auto mx-auto xl:ml-20 bg-white xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
            Reset password
        </h2>
        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
        <form class="needs-validation" action="{{ route('user.resetpassword') }}" method="post" id="resetPassword">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="intro-x mt-8">
                
                <input type="email" required class="form-control" placeholder="Email" name="email" value="{{ $email }}" style="display:none;">

                <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Password"  name="password" id="password"  required>

                <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" placeholder="Confirm Password" name="password_confirmation" required>
            </div>
            <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                <div class="flex items-center mr-auto">
                    <!-- <input type="checkbox" class="input border mr-2" id="remember-me">
                    <label class="cursor-pointer select-none" for="remember-me">Remember me</label> -->
                </div>
            </div>
            <div class="intro-x mt-5 xl:mt-10 text-center xl:text-left">
                <button class="btn btn-primary py-3 px-4 w-full xl:w-40 xl:mr-4 align-top">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection  
