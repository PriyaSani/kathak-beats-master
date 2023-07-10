@extends('layouts.admin')
@section('title','Dashboard')
@section('content')
<style>
.pie-chart-container,
.doughnut-chart-container {
  height: 360px;
  width: 360px;
  float: left;
}
</style>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            @if(in_array(2,$getDashBoardElement))
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Summary
                        </h2>
                        <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <a href="{{ route('admin.facultyList') }}" target="_blank">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user-plus" class="report-box__icon text-theme-10 "></i> 
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $faculties }}</div>
                                        <div class="text-base text-gray-600 mt-1">Faculties</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <a href="{{ route('admin.workshopList') }}" target="_blank">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="monitor" class="report-box__icon text-theme-11"></i> 
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $onlineWorkshops }}</div>
                                        <div class="text-base text-gray-600 mt-1">Online Workshops</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <a href="{{ route('admin.workshopList') }}" target="_blank">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="monitor" class="report-box__icon text-theme-9"></i> 
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $onlineBatchs }}</div>
                                        <div class="text-base text-gray-600 mt-1">Online Batches</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        

                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <a href="{{ route('admin.studentList') }}" target="_blank">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="users" class="report-box__icon text-theme-9"></i> 
                                        </div>
                                            <div class="text-3xl font-medium leading-8 mt-6">{{ $student }}</div>
                                            <div class="text-base text-gray-600 mt-1">Active Students</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <a href="{{ route('admin.workshopList') }}" target="_blank">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="map-pin" class="report-box__icon text-theme-12"></i> 
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $studioWorkshop }}</div>
                                        <div class="text-base text-gray-600 mt-1">Studio Workshops</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <a href="{{ route('admin.workshopList') }}" target="_blank">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="map-pin" class="report-box__icon text-theme-9"></i> 
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $studioBatchs }}</div>
                                        <div class="text-base text-gray-600 mt-1">Studio Batches</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        
                    </div>
                </div>
            @endif

            @if(in_array(4,$getDashBoardElement))
                <!-- END: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Download GST Report
                        </h2>
                    </div>
                    <form method="post" action="{{ route('generateInvoiceExcel') }}" />
                        @csrf
                        <div class="intro-y box p-5 mt-12 sm:mt-5">
                            <div class="grid grid-cols-3 gap-2 mt-5">
                                <div class="mt-3">
                                    <label>Select Date Range</label>
                                    <input data-daterange="true" class="datepicker form-control w-full block mx-auto col-span-3 mt-2 daterange" name="daterange" value="" placeholder="Start Date Range">
                                </div>

                                <div class="mt-5">
                                    <button type="submit" class="btn btn-primary w-30 mr-1 mt-5" name="btn_submit" value="save_and_add_new" >Generate Excel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            @if(in_array(1,$getDashBoardElement))
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Student Report
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <canvas id="student" width="250" height="100"></canvas>
                    </div>
                </div>
                <!-- END: Sales Report -->

                <!-- BEGIN: Weekly Top Seller -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Invoice & Payment Report
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <canvas id="amount" width="250" height="100"></canvas>
                    </div>
                </div>
            @endif

            @if(in_array(3,$getDashBoardElement))
                <div class="col-span-12 mt-8">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Inquiry Report
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-12 sm:mt-5">
                        <canvas id="inquiry" width="250" height="100"></canvas>
                    </div>
                </div>
            @endif
            <!-- END: Weekly Top Seller -->
        </div>
    </div>
</div>
@endsection