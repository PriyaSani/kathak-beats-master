<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> 
        <a href="{{ route('admin.dashboard') }}" @if(route::is('admin.dashboard')) class="breadcrumb--active" @endif>Dashboard</a> 
        @if(!route::is('admin.dashboard'))
            <i data-feather="chevron-right" class="breadcrumb__icon"></i> 
            <a href="" class="breadcrumb--active">@yield('title')</a> 
        @endif
    </div>
    
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">

        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
            <img alt="Midone Tailwind HTML Admin Template" src="{{ asset('uploads/profile') }}/{{ Auth::guard('admin')->user()->profile_image }}">
        </div>

        <div class="dropdown-menu w-56">
            <div class="dropdown-menu__content box bg-theme-33 dark:bg-dark-6 text-white">
                <div class="p-4 border-b border-theme-34 dark:border-dark-3">
                    <div class="font-medium">{{ Auth::guard('admin')->user()->name }}</div>
                    <!-- <div class="text-xs text-theme-35 mt-0.5 dark:text-gray-600">DevOps Engineer</div> -->
                </div>
                <div class="p-2">
                    <a href="{{ route('admin.profile') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                    <a href="{{ route('changeAdminPassword') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Change Password </a>
                </div>
                <div class="p-2 border-t border-theme-34 dark:border-dark-3">
                    <a href="{{ route('admin.logout') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>