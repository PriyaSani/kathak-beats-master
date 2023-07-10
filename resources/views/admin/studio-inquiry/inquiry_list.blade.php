@extends('layouts.admin')
@section('title','Studio Inquiry List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Studio Inquiry List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y box col-span-12 lg:col-span-12">
        <div class="p-5">
            <form method="post" action="{{ route('admin.inquiryList') }}">  
                @csrf
                <div class="grid grid-cols-3 gap-2 mt-5">

                    <div class="mt-3">
                        <label>Status</label>
                        <select class="form-control menulist col-span-3" name="status" id="status" data-msg="Select Status" >
                            <option value="{{ $status = '' }}">Status</option>
                            <option value="PENDING" @if($status == 'PENDING') selected="selected" @endif>Pending </option>
                            <option value="CONVERTED" @if($status == 'CONVERTED') selected="selected" @endif>Converted</option>
                            <option value="MISSED" @if($status == 'MISSED') selected="selected" @endif>Missed</option>
                            
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Inquiry Date</label>
                        <input data-daterange="true" class="datepicker form-control w-full block mx-auto daterange col-span-3" name="daterange" value="{{ $daterange }}">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                @if($filter == 1)
                    <a href="{{ route('admin.inquiryList') }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="whitespace-nowrap">Sr. No</th>
                    <th class="whitespace-nowrap">Inquiry Date</th>
                    <th class="whitespace-nowrap">Name</th>
                    <th class="text-center whitespace-nowrap">Email Id</th>
                    <th class="text-center whitespace-nowrap">Purpose</th>
                    <th class="text-center whitespace-nowrap">Contact Number</th>
                    <th class="text-center whitespace-nowrap">Whatsapp Number</th>
                    <th class="text-center whitespace-nowrap">Full Location</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($getInquiryList))
            	@foreach($getInquiryList as $ik => $iv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td>{{ date('d/m/Y',strtotime($iv->created_at)) }}</td>
	                    <td class="text-center">{{ $iv->full_name }}</td>
                        <td class="text-center">{{ $iv->email }}</td>
                        <td class="text-center">{{ $iv->purpose }}</td>
	                    <td class="text-center">{{ $iv->contact_number }}</td>
	                    <td class="text-center">{{ $iv->whatsapp_number }}</td>
	                    <td class="text-center">{{ $iv->address }}</td>
	                    <td class="w-40">
	                        <select class="form-control changeInquiryStatus" data-id="{{ $iv->uuid }}">
                                <option value="">Select Status</option>  
                                @if(!is_null(Config::get('constants.inqStatus')))
                                    @foreach(Config::get('constants.inqStatus') as $sk => $sv)
                                        <option value="{{ $sv }}" @if($sk == $iv->status) selected="selected" @endif>{{ $sv }}</option>
                                    @endforeach
                                @endif
                            </select>
	                    </td>
	                </tr>
	            @endforeach
	        @endif
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').val('');
    });
</script>
@endsection