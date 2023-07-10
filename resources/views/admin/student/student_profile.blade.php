@extends('layouts.admin')
@section('title','Student Profile')
@section('content')
<!-- END: Top Bar -->
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Student Profile
    </h2>
</div>
<!-- BEGIN: Profile Info -->
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                @if($details->profile_image != '')
                    <img alt="" class="rounded-full" src="{{ Config::get('constants.awsUrl') }}/student/{{ $details->profile_image }}">
                @else
                    <img alt="" class="rounded-full" src="{{ asset('dist/images/logo/logo.png') }}">
                @endif
                
            </div>
            <div class="ml-5">
                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $details->name }}</div>
                <!-- <div class="text-gray-600">DevOps Engineer</div> -->
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 dark:text-gray-300 px-5 border-l border-r border-gray-200 dark:border-dark-5 border-t lg:border-t-0 pt-5 lg:pt-0">
            <!-- <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div> -->
            <div class="flex flex-col justify-center iterationems-center lg:items-start mt-4">
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Contact Number : {{ $details->contact_number }}
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    Whatsapp Number : {{ $details->wp_number }}
                </div>

                <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                    EmailID :  {{ $details->email }}
                </div>
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
            <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                DOB :  {{ date('d M Y',strtotime($details->dob)) }} 
            </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                Payment Mode : {{ $details->mode }}
            </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-3"> 
                Billing Cycle : {{ $details->billing_cycle }}
            </div>
        </div>
    </div>
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start" role="tablist"> 
        
        <a data-toggle="tab" data-target="#batch" href="javascript:;" class="py-4 sm:mr-8 active" id="batch-tab" role="tab" aria-controls="batch" aria-selected="true">Batches & Workshop</a> 

        <a data-toggle="tab" data-target="#self" href="javascript:;" class="py-4 sm:mr-8 " id="self-tab" role="tab" aria-controls="self" aria-selected="true">Self learn</a> 

        <a data-toggle="tab" data-target="#pending" href="javascript:;" class="py-4 sm:mr-8 " id="pending-tab" role="tab" aria-controls="pending" aria-selected="true">Pending transaction</a> 

        <a data-toggle="tab" data-target="#all-transaction" href="javascript:;" class="py-4 sm:mr-8 " id="all-transaction-tab" role="tab" aria-controls="ll-transaction" aria-selected="true">All transaction</a> 

        <a data-toggle="tab" data-target="#invoice" href="javascript:;" class="py-4 sm:mr-8 " id="invoice-tab" role="tab" aria-controls="invoice" aria-selected="true">Invoices</a> 

        <!-- <a data-toggle="tab" data-target="#account-and-profile" href="javascript:;" class="py-4 sm:mr-8" id="account-and-profile-tab" role="tab" aria-selected="false">Profile</a>  -->

    </div>
</div>

<!-- END: Profile Info -->
<div class="intro-y tab-content mt-5">
    <div class="tab-pane active" id="batch" role="tabpanel" aria-labelledby="batch-tab">
        <div class="intro-y box col-span-12 lg:col-span-12">
            <div class="p-5">
                <form method="post" action="{{ route('admin.getStudentProfile',$details->uuid) }}">  
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
                                <option value="1" @if($engagement_mode == 1) selected="selected" @endif>Studio</option>
                                <option value="2" @if($engagement_mode == 2) selected="selected" @endif>Online</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label>Start Date Range</label>
                            <input class="form-control w-full block mx-auto col-span-3 " id="litepicker_start" name="start_daterange" value="{{ $startdate }}" placeholder="Start Date Range" >
                        </div>

                        <div class="mt-3">
                            <label>End Date Range</label>
                            <input class="form-control w-full block mx-auto col-span-3" id="litepicker_end" name="end_daterange" value="{{ $enddate }}" placeholder="End Date Range" >
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                    @if($filter == 1)
                        <a href="{{ route('admin.getStudentProfile',$details->uuid) }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
                    @endif
                </form>
            </div>
        </div><br />

        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y box col-span-12 lg:col-span-12 overflow-auto lg:overflow-hide px-5 pt-4">
                <a href="{{ route('admin.addbatchAndWorkshop',$details->uuid) }}" class="btn btn-danger mr-1 mb-4 floatright">Add Batch/Workshop</a>
                <table class="table table-report -mt-2" id="table_id">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Sr. No</th>
                            <th class="whitespace-nowrap">Title</th>
                            <th class="whitespace-nowrap">Engagement Type</th>
                            <th class="text-center whitespace-nowrap">Engagement Mode</th>
                            <th class="text-center whitespace-nowrap">Studio Name</th>
                            <th class="text-center whitespace-nowrap">Total sessions</th>
                            <th class="text-center whitespace-nowrap">Attended Sessions</th>
                            <th class="text-center whitespace-nowrap">Start Date</th>
                            <th class="text-center whitespace-nowrap">End Date</th>
                            <th class="text-center whitespace-nowrap">Status</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     @if(!is_null($getWorkshop))
                        @foreach($getWorkshop as $sk => $sv)
                            <tr class="intro-x workshop_{{ $sv->id }}">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $sv->workshop->title }}</td>
                                <td class="text-center">{{ $sv->workshop->engagement_type == 1 ? 'Batch' : 'Workshop' }}</td>
                                <td class="text-center">{{ $sv->workshop->engagement_mode == 1 ? 'Studio' : 'Online' }}</td>

                                <td class="text-center">{{ !is_null($sv->workshop->studio)  ? $sv->workshop->studio->name : '---------'  }}</td>
                                <td class="text-center">10</td>
                                <td class="text-center">0</td>
                                <td class="text-center">{{ date('d/m/Y',strtotime($sv->workshop->start_date)) }}</td>
                                <td class="text-center">{{ date('d/m/Y',strtotime($sv->workshop->end_date)) }}</td>
                                <td class="text-center">Active</td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center text-theme-6 unlinkWorkshop" href="javascript:void(0);" onclick="return confirm('Do you want to delete this student ?')" data-id="{{ $sv->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane " id="self" role="tabpanel" aria-labelledby="self-tab">
        <div class="grid grid-cols-12 gap-6">
            <div class="intro-y box col-span-12 lg:col-span-12 p-5">
                <h4>No Data to Show!</h4>
            </div>
        </div>
    </div>

    <div class="tab-pane " id="pending" role="tabpanel" aria-labelledby="pending-tab">
        <div class="grid box grid-cols-12 gap-12 px-5 pt-5">
            <div class="intro-y  col-span-12 lg:col-span-12">
                <table class="table table-report -mt-2" id="table_id_001">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Sr. No</th>
                            <th class="whitespace-nowrap">Title</th>
                            <th class="whitespace-nowrap">Engagement Type</th>
                            <th class="text-center whitespace-nowrap">Engagement Mode</th>
                            <th class="text-center whitespace-nowrap">Pending Since</th>
                            <th class="text-center whitespace-nowrap">Start Date</th>
                            <th class="text-center whitespace-nowrap">End Date</th>
                            <th class="text-center whitespace-nowrap">TXN Amount</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     @if(!is_null($getInvoice))
                        @foreach($getInvoice as $tk => $tv)
                            @if($tv->status == 'PENDING')
                                <tr class="intro-x">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $tv->workshop->title }}</td>
                                    <td class="text-center">{{ $tv->workshop->engagement_type == 1 ? 'Batch' : 'Workshop' }}</td>
                                    <td class="text-center">{{ $tv->workshop->engagement_mode == 1 ? 'Studio' : 'Online' }}</td>
                                    <td class="text-center">{{ date('d/m/Y',strtotime($tv->created_at)) }}</td>
                                    <td class="text-center">{{ date('d/m/Y',strtotime($tv->workshop->start_date)) }}</td>
                                    <td class="text-center">{{ date('d/m/Y',strtotime($tv->workshop->end_date)) }}</td>
                                    <td class="text-center">{{ $tv->amount }}</td>
                                    <td class="text-center update_{{ $tv->id }}">
                                        <a href="javascript:void(0);" class="btn btn-primary w-30 mr-1 mb-2 mt-4 markPaid_{{ $tv->id }} markPaid" data-id="{{ $tv->id }}" >Mark as paid</a>
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

    <div class="tab-pane " id="all-transaction" role="tabpanel" aria-labelledby="all-transaction-tab">
        <div class="grid box grid-cols-12 gap-12 px-5 pt-5">
            <div class="intro-y  col-span-12 lg:col-span-12">
                <table class="table table-report -mt-2" id="table_id_001">
                    <thead>
                        <tr>
                            <th class="text-center whitespace-nowrap">Sr. No</th>
                            <th class="text-center whitespace-nowrap">Title</th>
                            <th class="text-center whitespace-nowrap">Transaction Amount</th>
                            <th class="text-center whitespace-nowrap">Transaction Date & Time</th>
                            <th class="text-center whitespace-nowrap">TXN Status</th>
                            <th class="text-center whitespace-nowrap">Invoice Status</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     @if(!is_null($getInvoice))
                        @foreach($getInvoice as $tk => $tv)
                            @if($tv->file != '')
                                <tr class="intro-x">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $tv->workshop->title }}</td>
                                    <td class="text-center">{{ $tv->amount }}</td>
                                    <td class="text-center">{{ date('d/m/Y',strtotime($tv->invoice_date)) }}</td>
                                    <td class="text-center">{{ $tv->transaction_id }}</td>
                                    <td class="text-center">{{ $tv->file == '' ? 'PENDING' : 'GENERATED' }}</td>
                                    <td class="text-center">
                                       <!--  <a class="flex items-center mr-3" href="javascript:void(0);"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Attach </a> -->
                                        <a class="flex items-center mr-3" href="https://kathakbeats-prod.s3.ap-south-1.amazonaws.com/uploads/invoice/{{ $tv->file  }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Download </a>
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

    <div class="tab-pane " id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
        <div class="grid box grid-cols-12 gap-12 px-5 pt-5">
            <div class="intro-y  col-span-12 lg:col-span-12">
                <table class="table table-report -mt-2" id="table_id_001">
                    <thead>
                        <tr>
                            <th class="text-center whitespace-nowrap">Sr. No</th>
                            <th class="text-center whitespace-nowrap">Invoice No</th>
                            <th class="text-center whitespace-nowrap">Amount</th>
                            <th class="text-center whitespace-nowrap">Invoice Date & Time</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     @if(!is_null($getInvoice))
                        @foreach($getInvoice as $sk => $sv)
                            @if($sv->file != '')
                                <tr class="intro-x">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $sv->invoice_number }}</td>
                                    <td class="text-center">{{ $sv->amount }}</td>
                                    <td class="text-center">{{ date('d/m/Y H:i A',strtotime($sv->created_at)) }}</td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center text-theme-6" href="https://kathakbeats-prod.s3.ap-south-1.amazonaws.com/uploads/invoice/{{ $sv->file  }}">  Download </a>
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
</div>
@endsection
@section('js')
<script type="text/javascript">

    $(document).on('click','.markPaid',function(){
        var invoice_id = $(this).data('id');

        $.ajax({
            url:'/kb-backend/student/mark-as-paid',
            type:'post',
            data:{
                invoice_id : invoice_id
            },
            success:function(data){
                $('.markPaid_'+invoice_id).hide();
                $('.update_'+invoice_id).text('PAID');
            }
        });
    });
</script>
@endsection