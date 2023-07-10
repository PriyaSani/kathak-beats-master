<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Midone Tailwind HTML Admin Template" class="w-10" src="{{ asset('dist/images/logo/logo.png') }}">
        <span class="hidden xl:block text-white text-lg ml-3"> Kathak<span class="font-medium">Beats</span> </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}" class="side-menu @if(route::is('admin.dashboard')) side-menu--active @endif">
                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                <div class="side-menu__title"> Dashboard </div>
            </a>
        </li>

        @if(in_array('faculty',$module))
            <li>
                <a href="javascript:;" class="side-menu @if(route::is('admin.addFaculty') || route::is('admin.facultyList')) side-menu--active @endif">
                    <div class="side-menu__icon"> <i data-feather="user-plus"></i> </div>
                    <div class="side-menu__title">
                        Faculty 
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul @if(route::is('admin.addFaculty') || route::is('admin.facultyList')) class="side-menu__sub-open"  style="display: block;" @endif>
                    <li>
                        <a href="{{ route('admin.addFaculty') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Add Faculty </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.facultyList') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Faculty List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('student',$module))
            <li>
                <a href="javascript:;" class="side-menu @if(route::is('admin.addStudent') || route::is('admin.studentList')) side-menu--active @endif">
                    <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                    <div class="side-menu__title">
                        Student 
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul @if(route::is('admin.addStudent') || route::is('admin.studentList')) class="side-menu__sub-open"  style="display: block;" @endif>
                    <li>
                        <a href="{{ route('admin.addStudent') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Add Student </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.studentList') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Student List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('inquiry',$module))
            @php $count = \App\Models\StudioInquiry::where('is_seen',0)->count(); @endphp
            <li>
                <a href="{{ route('admin.inquiryList') }}" class="side-menu @if(route::is('admin.inquiryList')) side-menu--active  @endif">
                    <div class="side-menu__icon"> <i data-feather="message-square"></i> </div>
                    <div class="side-menu__title"> Inquiries <span class="badge" style="padding:0 4px 0 4px">{{ $count }}</span></div>
                </a>
            </li>
        @endif

        @if(in_array('cms',$module))
            <li>
                <a href="javascript:;" class="side-menu @if(route::is('admin.editLatestWork') || route::is('admin.addImage') || route::is('admin.imageList') || route::is('admin.addVideo') || route::is('admin.videoList')) side-menu--active @endif">
                    <div class="side-menu__icon"> <i data-feather="monitor"></i> </div>
                    <div class="side-menu__title">
                        CMS Modules 
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul @if(route::is('admin.editLatestWork') || route::is('admin.addImage') || route::is('admin.imageList') || route::is('admin.addVideo') || route::is('admin.videoList')) class="side-menu__sub-open"  style="display: block;" @endif>
                    <li>
                        <a href="{{ route('admin.editLatestWork') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="clock"></i> </div>
                            <div class="side-menu__title"> Latest Work Module </div>
                        </a>
                    </li>
                    <li @if(route::is('admin.addImage') || route::is('admin.imageList')) class="side-menu__sub-open"  style="display: block;" @endif>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="plus-square"></i> </div>
                            <div class="side-menu__title">
                                Gallery Module 
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="{{ route('admin.addImage') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title">Add Gallery</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.imageList') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title">Gallery List</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li @if(route::is('admin.addVideo') || route::is('admin.videoList')) class="side-menu__sub-open"  style="display: block;" @endif>
                        <a href="javascript:;" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="plus-square"></i> </div>
                            <div class="side-menu__title">
                                Video Module 
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="{{ route('admin.addVideo') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title">Add Video</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.videoList') }}" class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title">Video List</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('studio',$module))
            <li>
                <a href="javascript:;" class="side-menu @if(route::is('admin.studioList')) side-menu--active  @endif">
                    <div class="side-menu__icon"> <i data-feather="map-pin"></i> </div>
                    <div class="side-menu__title">
                        Studio 
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul @if(route::is('admin.addStudio') || route::is('admin.studioList')) class="side-menu__sub-open"  style="display: block;" @endif>
                    <li>
                        <a href="{{ route('admin.addStudio') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Add Studio </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.studioList') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Studio List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('batch',$module))
            <li>
                <a href="javascript:;" class="side-menu @if(route::is('admin.addWorkshop') || route::is('admin.workshopList')) side-menu--active  @endif">
                    <div class="side-menu__icon"> <i data-feather="award"></i> </div>
                    <div class="side-menu__title">
                        Workshops & Batches 
                        <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul @if(route::is('admin.addWorkshop') || route::is('admin.workshopList')) class="side-menu__sub-open"  style="display: block;" @endif>
                    <li>
                        <a href="{{ route('admin.addWorkshop') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Add Workshops & Batches </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.workshopList') }}" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Workshops & Batches List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('course',$module))
        <li>
            <a href="javascript:;" class="side-menu @if(route::is('admin.courseList')) side-menu--active  @endif">
                <div class="side-menu__icon"> <i data-feather="monitor"></i> </div>
                <div class="side-menu__title">
                    Course 
                    <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul @if(route::is('admin.addCourse') || route::is('admin.courseList')) class="side-menu__sub-open"  style="display: block;" @endif>
                <li>
                    <a href="{{ route('admin.addCourse') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Add Course </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.courseList') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Course List </div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(in_array('invoice',$module))
        <li>
            <a href="javascript:;" class="side-menu @if(route::is('admin.invoiceList')) side-menu--active side-menu @endif">
                <div class="side-menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="side-menu__title">
                    Invoice 
                    <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                </div>
            </a>
            <ul @if(route::is('admin.addInvoice') || route::is('admin.invoiceList')) class="side-menu__sub-open"  style="display: block;" @endif>
                <li>
                    <a href="{{ route('admin.addInvoice') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Add Invoice </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.invoiceList') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title"> Invoice List </div>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        @if(in_array('student',$module))
            <li>
                <a href="{{ route('admin.blockUserList') }}" class="side-menu @if(route::is('admin.blockUserList')) side-menu--active @endif">
                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                    <div class="side-menu__title"> Unblock Student </div>
                </a>
            </li>
        @endif
    </ul>
</nav>
