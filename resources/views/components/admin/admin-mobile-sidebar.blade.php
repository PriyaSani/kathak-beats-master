<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Kathak Beats" class="w-10" src="{{ asset('dist/images/logo/logo.png') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class="border-t border-theme-21 py-5 hidden">

        <li>
            <a href="{{ route('admin.dashboard') }}" class="menu">
                <div class="menu__icon"> <i data-feather="home"></i> </div>
                <div class="menu__title"> Dashboard </div>
            </a>
        </li>

        @if(in_array('faculty',$module))
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="user-plus"></i> </div>
                    <div class="menu__title"> Faculty <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ route('admin.addFaculty') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Add Faculty </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.facultyList') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Faculty List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('student',$module))
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="users"></i> </div>
                    <div class="menu__title"> Student <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ route('admin.addStudent') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Add Student </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.studentList') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Student List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('inquiry',$module))
            @php $count = \App\Models\StudioInquiry::where('is_seen',0)->count(); @endphp
            <li>
                <a href="{{ route('admin.inquiryList') }}" class="menu">
                    <div class="menu__icon"> <i data-feather="calendar"></i> </div>
                    <div class="menu__title"> Studio Inquiry <span class="badge">{{ $count }}</span></div>
                </a>
            </li>
        @endif

        @if(in_array('cms',$module))
            <li>
                <a href="javascript:;" class="menu @if(route::is('admin.editLatestWork')) menu--active menu--open @endif">
                    <div class="menu__icon"> <i data-feather="monitor"></i> </div>
                    <div class="menu__title">
                        CMS Modules 
                        <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ route('admin.editLatestWork') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="clock"></i> </div>
                            <div class="menu__title"> Latest Work Module </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="plus-square"></i> </div>
                            <div class="menu__title">
                                Gallery Module 
                                <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="{{ route('admin.addImage') }}" class="menu">
                                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="menu__title">Add Gallery</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.imageList') }}" class="menu">
                                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="menu__title">Gallery List</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="plus-square"></i> </div>
                            <div class="menu__title">
                                Video Module 
                                <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="{{ route('admin.addVideo') }}" class="menu">
                                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="menu__title">Add Video</div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.videoList') }}" class="menu">
                                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="menu__title">Video List</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('studio',$module))
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="map-pin"></i> </div>
                    <div class="menu__title"> Studio <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ route('admin.addStudio') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Add Studio </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.studioList') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Studio List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('batch',$module))
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="award"></i> </div>
                    <div class="menu__title">
                        batch 
                        <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ route('admin.addWorkshop') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Add Batch </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.workshopList') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Batch List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('course',$module))
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="award"></i> </div>
                    <div class="menu__title">
                        Course 
                        <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ route('admin.addCourse') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Add Course </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.courseList') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Course List </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(in_array('invoice',$module))
            <li>
                <a href="javascript:;" class="menu">
                    <div class="menu__icon"> <i data-feather="award"></i> </div>
                    <div class="menu__title">
                        Invoice 
                        <div class="menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ route('admin.addInvoice') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Add Invoice </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.invoiceList') }}" class="menu">
                            <div class="menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="menu__title"> Invoice List </div>
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
</div>