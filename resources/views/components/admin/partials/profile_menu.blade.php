<div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
    <div class="intro-y box mt-5">
        <div class="relative flex items-center p-5">
            <div class="w-12 h-12 image-fit">
                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('uploads/profile') }}/{{ Auth::guard('admin')->user()->profile_image ?  Auth::guard('admin')->user()->profile_image : 'profile.jpg'}}">
            </div>
            <div class="ml-4 mr-auto">
                <div class="font-medium text-base">{{ Auth::guard('admin')->user()->name }}</div>
                <div class="text-gray-600">Admin</div>
            </div>
        </div>
        <div class="p-5 border-t border-gray-200 dark:border-dark-5">
            <a class="flex items-center @if(route::is('admin.profile')) text-theme-1 dark:text-theme-10 font-medium @endif" href="{{ route('admin.profile') }}"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Personal Information </a>
            <a class="flex items-center mt-5 @if(route::is('changeAdminPassword')) text-theme-1 dark:text-theme-10 font-medium @endif" href="{{ route('changeAdminPassword') }}"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Change Password </a>
        </div>
    </div>
</div>