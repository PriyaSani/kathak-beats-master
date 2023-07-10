@extends('layouts.admin')
@section('title','Faculty Profile')
@section('content')
<!-- END: Top Bar -->
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Profile Layout
    </h2>
</div>
<!-- BEGIN: Profile Info -->
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                <img class="rounded-full" src="{{ Config::get('constants.awsUrl') }}/profile/{{ $details->profile_image }}" alt="{{ $details->name }}">
                <!-- <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-theme-1 rounded-full p-2"> <!-- <i class="w-4 h-4 text-white" data-feather="camera"></i> </div> -->
            </div>
            <div class="ml-5">
                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $details->name }}</div>
                <!-- <div class="text-gray-600">DevOps Engineer</div> -->
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
            <!-- <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div> -->
            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                <div class="truncate sm:whitespace-normal flex items-center"> 
                    DOB :  {{ date('d M Y',strtotime($details->dob)) }} 
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Blood Group : {{ strtoupper($details->blood_group) }}
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Contact Number : {{ $details->mobile }}
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Email ID : {{ $details->email }}
                </div>
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
            <div class="truncate sm:whitespace-normal flex items-center"> 
                No of Batches :  {{ $getBatchCount }}
            </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                No of Workshop : {{ $getWorkshopCount }}
            </div>
        </div>
    </div>
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start" role="tablist"> 
        
        <a data-toggle="tab" data-target="#dashboard" href="javascript:;" class="py-4 sm:mr-8 active" id="dashboard-tab" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a> 

        <!-- <a data-toggle="tab" data-target="#account-and-profile" href="javascript:;" class="py-4 sm:mr-8" id="account-and-profile-tab" role="tab" aria-selected="false">Profile</a>  -->

    </div>
</div>

<!-- END: Profile Info -->
<div class="intro-y tab-content mt-5">
    <div class="tab-pane active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Top Categories -->
            <div class="intro-y box col-span-12 lg:col-span-12">
                <div class="p-5">
                    <form method="post" action="{{ route('admin.facultyProfile',$details->uuid) }}">  
                        @csrf
                        <div class="grid grid-cols-3 gap-2 mt-5">
                            <div class="mt-3">
                                <label>Engagement Type</label>
                                <select class="form-control menulist col-span-3" name="engagement_type" id="engagement_type" data-msg="Select engagement type" >
                                    <option value="">Select Engagement Type</option>
                                    <option value="1" @if($engagement_type == 1) selected="selected" @endif>Batch</option>
                                    <option value="2" @if($engagement_type == 2) selected="selected" @endif>Workshop</option>
                                </select>
                            </div>

                            <div class="mt-3">
                                <label>Engagement Mode</label>
                                <select class="form-control menulist col-span-3" name="engagement_mode" data-msg="Select engagement mode" >
                                    <option value="">Select Engagement Mode</option>
                                    <option value="1" @if($engagement_mode == 2) selected="selected" @endif>Studio</option>
                                    <option value="2" @if($engagement_mode == 2) selected="selected" @endif>Online</option>
                                </select>
                            </div>

                            <div class="mt-3">
                                <label>Start Date</label>
                                <input class="datepicker form-control w-full block mx-auto col-span-3 daterange" name="start_date" @if($startDate != '') value="{{ $startDate }}" @endif placeholder="Start Date" data-daterange="true">
                            </div>

                            <div class="mt-3">
                                <label>End Date</label>
                                <input class="datepicker form-control w-full block mx-auto col-span-3 daterange" name="end_date" @if($endDate != '') value="{{ $endDate }}" @endif placeholder="End Date" data-daterange="true">
                            </div>

                            <div class="mt-3">
                                <label>Studio</label>
                                <select class="form-control menulist col-span-3" name="studio_type" id="studio_type" data-msg="Select Studio">
                                    <option value="">Select Studio</option>
                                    @if(!is_null($studio))
                                        @foreach($studio as $sk => $sv)
                                            <option value="{{ $sv->id }}" @if($sv->id == $studio_type) selected="selected" @endif>{{ $sv->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                    </form>
                </div>
            </div>

            <!-- END: Top Categories -->
            <!-- BEGIN: Work In Progress -->
            <div class="intro-y box col-span-12 lg:col-span-12 p-3 overflow-auto lg:overflow-hide">
                <div class="p-3" style="float:right;">
                    <a href="{{ route('admin.getBatchList',$details->uuid) }}" class="btn btn-danger col-span-4 ">Add Engagement</a>
                </div>
                <table class="table table-report -mt-2" id="table_id">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Sr. No</th>
                            <th class="whitespace-nowrap">Title</th>
                            <th class="text-center whitespace-nowrap">Start Date</th>
                            <th class="text-center whitespace-nowrap">End Date</th>
                            <th class="text-center whitespace-nowrap">Engagement Type</th>
                            <th class="text-center whitespace-nowrap">Engagement Mode</th>
                            <th class="text-center whitespace-nowrap">Studio</th>
                            <th class="text-center whitespace-nowrap">No of Participants</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($workshop))
                        @foreach($workshop as $fk => $fv)
                            <tr class="intro-x" id="row_{{ $fv->id }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <a href="" class="font-medium whitespace-nowrap">{{ $fv->title }}</a> 
                                </td>
                                <td class="text-center">{{ date('d/m/Y',strtotime($fv->start_date)) }}</td>
                                <td class="text-center">{{ date('d/m/Y',strtotime($fv->end_date)) }}</td>
                                <td class="text-center">{{ $fv->engagement_type == 1 ? 'Batch' : 'Workshop'}}</td>
                                <td class="text-center">{{ $fv->engagement_mode == 1 ? 'Studio' : 'Online' }}</td>
                                <td class="text-center">{{ !is_null($fv->studio) ?  $fv->studio->name : '------' }}</td>
                                <td class="text-center">0</td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center text-theme-6 unlinkFaculty" href="javascript:void(0);" onclick="return confirm('Do you want to unlink yourself from this workshop?')" data-id="{{ $fv->id }}" data-value="{{ $details->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- END: Work In Progress -->
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').val('');
    });
</script>
@endsection