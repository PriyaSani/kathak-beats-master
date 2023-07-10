@extends('layouts.admin')
@section('title','Engagement Settings')
@section('content')
<!-- END: Top Bar -->
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Engagement Settings
    </h2>
</div>
<!-- BEGIN: Profile Info -->
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                <img class="rounded-full" src="{{ Config::get('constants.awsUrl') }}/poster/{{ $details->poster }}" alt="{{ $details->title }}">
            </div>
            <div class="ml-5">
                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $details->title }}</div>
                <!-- <div class="text-gray-600">DevOps Engineer</div> -->
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
            <!-- <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div> -->
            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                <div class="truncate sm:whitespace-normal flex items-center"> 
                    Type :  {{ $details->engagement_type == 1 ? 'Batch' : 'Workshop' }}
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Mode : {{ $details->engagement_mode == 1 ? 'Studio' : 'Online' }}
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Frequency / Week : {{ $details->frequency }}
                </div>
                <?php $faculty = array(); ?>
                @if(!is_null($details->workshopfaculty))
                    @foreach($details->workshopfaculty as $wk => $wv)
                        @if(!is_null($wv->faculty))
                            <?php $faculty[] = $wv->faculty->name; ;?>
                        @endif
                    @endforeach
                @endif
                   
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Instructor :  {{ implode(' | ',$faculty) }}
                </div>
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
            @if($details->engagement_type == 1)
                @if(!is_null($details->timetable))
                    @foreach($details->timetable as $tk => $tv)    
                        <div class="truncate sm:whitespace-normal flex items-cente @if($tk > 0) mt-3 @endif"> 
                            {{ $darray[$tv->day_id] }} : {{ $tv->start_time }} - {{ $tv->end_time }}
                        </div>
                    @endforeach
                @endif
            @else 
                @if(!is_null($details->timetable))
                    @foreach($details->timetable as $tk => $tv)    
                        <div class="truncate sm:whitespace-normal flex items-center @if($tk > 0) mt-3 @endif"> 
                            {{ $tv->date }} : {{ $tv->start_time }} - {{ $tv->end_time }}
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start" role="tablist"> 
        
        <a data-toggle="tab" data-target="#dashboard" href="javascript:;" class="py-4 sm:mr-8 active" id="dashboard-tab" role="tab" aria-controls="dashboard" aria-selected="true">Students</a> 

        <a data-toggle="tab" data-target="#updates" href="javascript:;" class="py-4 sm:mr-8" id="updates-tab" role="tab" aria-controls="updates" aria-selected="true">Updates</a> 

        <a data-toggle="tab" data-target="#images" href="javascript:;" class="py-4 sm:mr-8" id="images-tab" role="tab" aria-controls="images" aria-selected="true">Images</a> 

        <a data-toggle="tab" data-target="#documents" href="javascript:;" class="py-4 sm:mr-8" id="documents-tab" role="tab" aria-controls="documents" aria-selected="true">Documents</a> 

        <a data-toggle="tab" data-target="#attendance" href="javascript:;" class="py-4 sm:mr-8" id="attendance-tab" role="tab" aria-controls="attendance" aria-selected="true">Attendance</a> 

    </div>
</div>

<!-- END: Profile Info -->
<div class="intro-y tab-content mt-5">
    <div class="tab-pane active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
        
        <div class="intro-y box col-span-12 lg:col-span-12">
            <div class="p-5">
                <form method="post" action="{{ route('admin.engagementSetting',$details->uuid) }}">  
                    
                    @csrf

                    <input type="hidden" name="filter" value="student">

                    <div class="grid grid-cols-3 gap-2 mt-5">
                        <div class="mt-3">
                            <label>Registration Mode</label>
                            <select class="form-control menulist col-span-4" name="registration_mode" id="registration_mode" >
                                <option value="">Select Registration Mode</option>
                                <option value=""  @if($registration_mode == "") selected="selected" @endif>All</option>
                                <option value="OFFLINE" @if($registration_mode == 'OFFLINE') selected="selected" @endif>Offline</option>
                                <option value="ONLINE" @if($registration_mode == 'ONLINE') selected="selected" @endif>Online</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label>Payment Frequency</label>
                            <select class="form-control menulist col-span-4" name="payment_frequency" data-msg="Select engagement mode" >
                                <option value="">Select Payment Frequency</option>
                                <option value=""  @if($payment_frequency == "") selected="selected" @endif>All</option>
                                <option value="MONTHLY" @if($payment_frequency == 'MONTHLY') selected="selected" @endif>Monthly</option>
                                <option value="QUARTERLY" @if($payment_frequency == 'QUARTERLY') selected="selected" @endif>Quarterly</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label>Registration Date Range</label>
                            <input data-daterange="true" class="datepicker form-control w-full block mx-auto col-span-4 daterange" id="daterange" name="daterange" value="{{ $date_val }}" placeholder="Registration Date Range" autocomplete="off">
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                    @if($studentFilter == 1)
                        <a href="{{ route('admin.engagementSetting',$details->uuid) }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
                    @endif
                </form>
            </div>
        </div><br />

        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y box col-span-12 lg:col-span-12 overflow-auto lg:overflow-hide px-5 pt-4">
                <a href="{{ route('admin.addEngagementStudent',$details->uuid) }}" class="btn btn-danger mr-1 mb-4 floatright">Add Student</a>
                <table class="table table-report -mt-2" id="table_id">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Sr. No</th>
                            <th class="whitespace-nowrap">Name</th>
                            <th class="text-center whitespace-nowrap">Mobile</th>
                            <th class="text-center whitespace-nowrap">Whatsapp No</th>
                            <th class="text-center whitespace-nowrap">Email ID</th>
                            <th class="text-center whitespace-nowrap">Registration Mode</th>
                            <!-- <th class="text-center whitespace-nowrap">Payment Frequency</th> -->
                            <th class="text-center whitespace-nowrap">Registered On</th>
                            <th class="text-center whitespace-nowrap">Access Status</th>
                            <th class="text-center whitespace-nowrap">Batch Status</th>
                            <th class="text-center whitespace-nowrap">Batch Payment</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($studentList))
                        @foreach($studentList as $fk => $fv)
                            @if(!is_null($fv->users))
                                @if($details->engagement_type == 1 && $details->engagement_mode == 1)
                                    <tr class="intro-x" id="row_{{ $fv->id }}">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $fv->users->name }}</td>
                                        <td class="text-center">{{ $fv->users->contact_number }}</td>
                                        <td class="text-center">{{ $fv->users->wp_number }}</td>
                                        <td class="text-center">{{ $fv->users->email }}</td>
                                        <td class="text-center">{{ $fv->users->mode }}</td>
                                        <td class="text-center">{{ date('d/m/Y',strtotime($fv->users->created_at)) }}</td>
                                        <td class="text-center">
                                             <input class="form-check-switch ml-auto changeWorkshopStudent" type="checkbox" @if($fv->is_active == 1) checked="checked" @endif data-id="{{ $fv->id }}">
                                        </td>
                                        <td class="text-center">
                                            <select class="studentBatchStatus" data-id="{{ $fv->id }}">
                                                <option class="CONTINUE" @if($fv->batch_status == 'CONTINUE') selected="selected" @endif>Continue</option>
                                                <option class="BREAK" @if($fv->batch_status == 'BREAK') selected="selected" @endif>Break</option>
                                                <option class="LEFT" @if($fv->batch_status == 'LEFT') selected="selected" @endif>Left</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <select class="studentMonthlyCycle" data-id="{{ $fv->id }}">
                                                <option class="MONTHLY" @if($fv->invoice_cycle == 'MONTHLY') selected="selected" @endif>Monthly</option>
                                                <option class="QUARTERLY" @if($fv->invoice_cycle == 'QUARTERLY') selected="selected" @endif>Quarterly</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <a class="flex items-center text-theme-6 unlinkUser" href="javascript:void(0);" onclick="return confirm('Do you want to unlink this student from batch ?')" data-id="{{ $fv->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        </td>
                                    </tr>
                                @else
                                    @php
                                        $studentInvoice = \App\Models\Invoice::where('user_id',$fv->student_id)->where('workshop_id',$fv->workshop_id)->where('status','PAID')->first();
                                    @endphp
                                    @if(!is_null($studentInvoice))
                                        <tr class="intro-x" id="row_{{ $fv->id }}">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $fv->users->name }}</td>
                                            <td class="text-center">{{ $fv->users->contact_number }}</td>
                                            <td class="text-center">{{ $fv->users->wp_number }}</td>
                                            <td class="text-center">{{ $fv->users->email }}</td>
                                            <td class="text-center">{{ $fv->users->mode }}</td>
                                            <td class="text-center">{{ date('d/m/Y',strtotime($fv->users->created_at)) }}</td>
                                            <td class="text-center">
                                                 <input class="form-check-switch ml-auto changeWorkshopStudent" type="checkbox" @if($fv->is_active == 1) checked="checked" @endif data-id="{{ $fv->id }}">
                                            </td>
                                            <td class="text-center">
                                                <select class="studentBatchStatus" data-id="{{ $fv->id }}">
                                                    <option class="CONTINUE" @if($fv->batch_status == 'CONTINUE') selected="selected" @endif>Continue</option>
                                                    <option class="BREAK" @if($fv->batch_status == 'BREAK') selected="selected" @endif>Break</option>
                                                    <option class="LEFT" @if($fv->batch_status == 'LEFT') selected="selected" @endif>Left</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <select class="studentMonthlyCycle" data-id="{{ $fv->id }}">
                                                    <option class="MONTHLY" @if($fv->invoice_cycle == 'MONTHLY') selected="selected" @endif>Monthly</option>
                                                    <option class="QUARTERLY" @if($fv->invoice_cycle == 'QUARTERLY') selected="selected" @endif>Quarterly</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <a class="flex items-center text-theme-6 unlinkUser" href="javascript:void(0);" onclick="return confirm('Do you want to unlink this student from batch ?')" data-id="{{ $fv->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="updates" role="tabpanel" aria-labelledby="updates-tab">
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y box col-span-12 lg:col-span-12">
                <div class="p-5">
                    <form method="post" action="{{ route('admin.engagementSetting',$details->uuid) }}">  
                        @csrf
                        <input type="hidden" name="filter" value="update">

                        <div class="grid grid-cols-3 gap-2 mt-5">
                            <div class="mt-3">
                                <label>Update Date Range</label>
                                <input data-daterange="true" class="datepicker form-control w-full block mx-auto col-span-4 daterange" name="update_daterange" value="{{ $update_date_val }}" placeholder="Update Date Range">
                            </div>

                            <div class="mt-3">
                                <label>Status</label>
                                <select class="form-control menulist col-span-4" name="status" data-msg="Select engagement mode" >
                                    <option value="">Select Status</option>
                                    <option value="1" @if($status == '1') selected="selected" @endif>Active</option>
                                    <option value="2" @if($status == '2') selected="selected" @endif>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                        @if($updateFilter == 1)
                            <a href="{{ route('admin.engagementSetting',$details->uuid) }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="intro-y box col-span-12 lg:col-span-12 p-3">
                <a href="{{ route('admin.addCourse') }}?id={{ $details->uuid }}&medium=update" class="btn btn-danger mr-1 mb-4 floatright ">    Give Updates
                </a>
                <table class="table table-report -mt-2" id="table_id_001">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Sr. No</th>
                            <th class="text-center whitespace-nowrap">Update Content</th>
                            <th class="text-center whitespace-nowrap">URL</th>
                            <th class="text-center whitespace-nowrap">Status</th>
                            <th class="text-center whitespace-nowrap">Date</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($getCourse))
                        @foreach($getCourse as $fk => $fv)
                            @if($fv->course->course_type == 1)
                                <tr class="intro-x table_row_{{ $fv->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $fv->course->message }}</td>
                                    <td class="text-center">
                                        @if($fv->course->url != '')
                                            <a href="{{ $fv->course->url }}" target="_blank"><u>Click Here</u></a>
                                        @else 
                                            -----
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-switch ml-auto changeUpdateStatus" type="checkbox" data-id="{{ $fv->id }}" data-content="{{ $fv->material_id }}" data-value="update" @if($fv->is_active == 1) checked="checked" @endif>
                                    </td>
                                    <td class="text-center">
                                        {{ date('d/m/Y',strtotime($fv->course->created_at)) }}
                                    </td>
                                    <td>
                                        <a class="flex items-center text-theme-6 unlinkCourse" href="javascript:void(0);" data-id="{{ $fv->id }}" data-content="{{ $fv->material_id }}" data-value="document"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="images" role="tabpanel" aria-labelledby="images-tab">
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y box col-span-12 lg:col-span-12 px-5 pt-5">
                <a href="{{ route('admin.addCourse') }}?id={{ $details->uuid }}&medium=images" class="btn btn-danger mr-1 mb-4 floatright">
                    Upload Images
                </a>
            </div>
        @if(!is_null($getCourse))
            @foreach($getCourse as $fk => $fv)
                @if($fv->course->course_type == 2)
                    <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 xxl:col-span-2 image_{{ $fv->id }}">
                        <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                            <a href="" class="w-3/5 file__icon file__icon--image mx-auto">
                                <div class="file__icon--image__preview image-fit">
                                    <img alt="course" src="{{ asset('uploads/course') }}/{{ $fv->course->course->uuid }}/images/{{ $fv->course->file_name }}">
                                </div>
                            </a>
                            <div class="absolute top-0 right-0 mr-2 mt-2 dropdown ml-auto">
                                <a href="javascript:void(0);" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md unlinkCourse" data-id="{{ $fv->id }}" data-content="{{ $fv->material_id }}" data-value="image"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash w-4 h-4 mr-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
        </div>
    </div>

    <div class="tab-pane" id="documents" role="tabpanel" aria-labelledby="documents-tab">
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y box col-span-12 lg:col-span-12 px-5 pt-5">
                <a href="{{ route('admin.addCourse') }}?id={{ $details->uuid }}&medium=documents" class="btn btn-danger mr-1 mb-4 floatright">
                    Add Documents
                </a>
                <table class="table table-report -mt-2" id="table_id_003">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Sr. No</th>
                            <th class="text-center whitespace-nowrap">Title</th>
                            <th class="text-center whitespace-nowrap">Uploaded On</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($getCourse))
                        @foreach($getCourse as $fk => $fv)
                            @if($fv->course->course_type == 3)
                                <tr class="intro-x table_row_{{ $fv->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $fv->course->title }}</td>
                                    <td class="text-center">{{ date('d/m/Y',strtotime($fv->course->created_at)) }}</td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="https://kathakbeats-prod.s3.ap-south-1.amazonaws.com/uploads/course/{{ $fv->course->course->uuid }}/document/{{ $fv->course->file_name }}" target="_blank"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Download </a>
                                            <a class="flex items-center text-theme-6 unlinkCourse" href="javascript:void(0);" data-id="{{ $fv->id }}" data-content="{{ $fv->material_id }}" data-value="document"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
        <div class="grid box grid-cols-12 gap-12 px-5 pt-5">
             <div class="intro-y  col-span-12 lg:col-span-12">
                <table class="table table-report -mt-2" id="table_id_004">
                    <thead>
                        <tr>    
                            <th class="whitespace-nowrap">Sr. No</th>
                            <th class="text-center whitespace-nowrap">Date</th>
                            <th class="text-center whitespace-nowrap">Type</th>
                            <th class="text-center whitespace-nowrap">Total Registration</th>
                            <th class="text-center whitespace-nowrap">No of Attendance</th>
                            <th class="text-center whitespace-nowrap">Status</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!is_null($attData))
                        @foreach($attData as $ak => $av)
                            <tr>
                                <td class="text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-center whitespace-nowrap">
                                    {{ date('d/m/Y',strtotime($av['date'])) }} 
                                    
                                </td>
                                <td class="text-center whitespace-nowrap">
                                    @if($av['is_reschedule'] == 1)
                                        <button class="btn btn-rounded btn-danger-soft w-24 mr-1 mb-2">Reschedule</button>
                                    @else
                                        <button class="btn btn-rounded btn-success-soft w-24 mr-1 mb-2">Normal</button>
                                    @endif
                                </td>
                                <td class="text-center whitespace-nowrap">{{ count($studentList) }}</td>
                                <td class="text-center whitespace-nowrap">{{ $av['attendees'] }}</td>
                                <td class="text-center whitespace-nowrap">{{ $av['status'] == 1 ? 'Marked' : 'Pending' }}</td>
                                <td class="table-report__action w-56">
                                    @if($av['status'] != 1)
                                        <div class="flex justify-center items-center">
                                            @if(date('Y-m-d') < $av['date'])
                                                <a class="flex items-center mr-3 modify" href="javascript:void(0);" data-toggle="modal" data-target="#header-footer-modal-preview" data-id="{{ $av['id'] }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Modify </a>
                                            @elseif(date('Y-m-d') == $av['date'] || date('Y-m-d') > $av['date'])
                                                @php 
                                                    $currentTime = date('Y-m-d h:i:s');
                                                    $batchTime = date('Y-m-d h:i:s',strtotime($av['date'].' '.$av['start_time']));
                                                @endphp
                                                @if($currentTime > $batchTime)
                                                    <a class="flex items-center mr-3" href="{{ route('admin.markAttendance',$av['id']) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Mark </a>
                                                @endif
                                            @endif
                                        </div>
                                    @else 
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="{{ route('admin.editAttendance',$av['id']) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="header-footer-modal-preview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Modify Date
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form method="post" action="{{ route('admin.modifyTime') }}">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    
                </div>
            
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer text-right">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-20">Modify</button>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
@endsection
@section('js')
@if($date_val == '')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#daterange').val('')
        });
    </script>
@endif
<script type="text/javascript">
    $(document).on('click','.modify',function(){
        $.ajax({
            url: "/kb-backend/batch/get-attendance-detail",
            type: "POST",
            data:{ id:$(this).data('id')},
            success: function(data){
                $('.modal-body').html(data);
                $('.sdapicker').datepicker({
                    dateFormat: 'dd/mm/yy'
                });
            }
        });
    });

    $(document).on('change','.studentMonthlyCycle',function(){
        $.ajax({
            url: "/kb-backend/batch/change-invoice-cycle",
            type: "POST",
            data:{ workshop_student:$(this).data('id'),status:$(this).val()},
            success: function(data){
                if(data){
                    toastr['success']('Invoice cycle\'s status successfully changed');
                }
            }
        });
    });

    $(document).on('change','.studentBatchStatus',function(){
        $.ajax({
            url: "/kb-backend/batch/change-batch-status",
            type: "POST",
            data:{ workshop_student:$(this).data('id'),status:$(this).val()},
            success: function(data){
                if(data){
                    toastr['success']('Batch status successfully changed');
                }
            }
        });
    });

    
</script>
@endsection
