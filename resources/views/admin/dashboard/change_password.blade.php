@extends('layouts.admin')
@section('title','Change Password')
@section('content')
<div class="grid grid-cols-12 gap-6">

    <div class="grid gap-4 col-span-12 lg:col-span-6 xxl:col-span-9 ">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Change Password
                </h2>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('updateAdminPassword') }}" method="post" id="changePassword">
                    @csrf
                    <div>
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="input w-full form-control border mt-2" placeholder="Old password" required />
                    </div>
                    <div class="mt-3">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="input w-full form-control border mt-2" placeholder="New password" id="new_password" required />
                    </div>
                    <div class="mt-3">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" class="input form-control w-full border mt-2" placeholder="Confirm password" required />
                    </div>
                    <button class="btn btn-primary w-30 mr-1 mb-2 mt-4">Change Password</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection