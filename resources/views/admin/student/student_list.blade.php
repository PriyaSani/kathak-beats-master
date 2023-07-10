@extends('layouts.admin')
@section('title','Student List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Student List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <!-- <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
        </div>
    </div> -->
    <div class="intro-y box col-span-12 lg:col-span-12">
        <div class="p-5">
            <form method="post" action="{{ route('admin.studentList') }}">  
                @csrf
                <div class="grid grid-cols-3 gap-2 mt-5">

                    <div class="mt-3">
                        <label>Batch</label><br/>
                        <select name="batch_id" data-search="true" class="tail-select w-full col-span-4 ml-auto">
                            <option value="">Select Batch</option>
                            @if(!is_null($workshop))
                                @foreach($workshop as $wk => $wv)
                                    @if($wv->engagement_type == 1)
                                        <option value="{{ $wv->id }}" @if($wv->id == $batch_id) selected="selected" @endif>{{ $wv->title }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Workshop</label><br/>
                        <select name="workshop_id" data-search="true" class="tail-select w-full col-span-4 ml-auto" style="margin-right: 15px;">
                            <option value="">Select Workshop</option>
                            @if(!is_null($workshop))
                                @foreach($workshop as $wk => $wv)
                                    @if($wv->engagement_type == 2)
                                        <option value="{{ $wv->id }}" @if($wv->id == $workshop_id) selected="selected" @endif>{{ $wv->title }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Status</label>
                        <select class="form-control menulist col-span-3" name="status" id="status" data-msg="Select Status" >
                            <option value="">Status</option>
                            <option value="1" @if($status == 1) selected="selected" @endif>Active</option>
                            <option value="2" @if($status == 2) selected="selected" @endif>Inactive</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Country</label><br/>
                        <select data-search="true" class="tail-select w-full col-span-4 ml-auto" name="country_id" id="country_id" >
                            <option value="">Select Country</option>
                            @if(!is_null($country))
                                @foreach($country as $ck => $cv)
                                    <option value="{{ $cv->id }}" @if($cv->id == $countryFilter) selected="selected" @endif>{{ $cv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="mt-3">
                        <label>State</label><br/>
                        <select data-search="true" class="tail-select w-full col-span-4 ml-auto" name="state_id" id="state_id" >
                            <option value="">Select State</option>
                            @if(!is_null($state))
                                @foreach($state as $sk => $sv)
                                    <option value="{{ $sv->id }}" @if($sv->id == $stateFilter) selected="selected" @endif>{{ $sv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>City</label><br/>
                        <select data-search="true" class="tail-select w-full col-span-4 ml-auto" name="city_id" id="city_id" >
                            <option value="">Select City</option>
                            @if(!is_null($city))
                                @foreach($city as $ck => $cv)
                                    <option value="{{ $cv->id }}" @if($cv->id == $cityFilter) selected="selected" @endif >{{ $cv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Registration Mode</label>
                        <select class="form-control menulist col-span-3" name="registration_mode" id="registration_mode" >
                            <option value="">Select Registration Mode</option>
                            <option value=""  @if($registration_mode == "") selected="selected" @endif>All</option>
                            <option value="OFFLINE" @if($registration_mode == 'OFFLINE') selected="selected" @endif>Offline</option>
                            <option value="ONLINE" @if($registration_mode == 'ONLINE') selected="selected" @endif>Online</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Payment Frequency</label>
                        <select class="form-control menulist col-span-3" name="payment_frequency" data-msg="Select engagement mode" >
                            <option value="">Select Payment Frequency</option>
                            <option value=""  @if($payment_frequency == "") selected="selected" @endif>All</option>
                            <option value="MONTHLY" @if($payment_frequency == 'MONTHLY') selected="selected" @endif>Monthly</option>
                            <option value="QUARTERLY" @if($payment_frequency == 'QUARTERLY') selected="selected" @endif>Quarterly</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Daterange</label>
                        <input data-daterange="true" class="datepicker form-control w-full block mx-auto daterange col-span-3" name="daterange" value="{{ $birthdate }}">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                @if($filter == 1)
                    <a href="{{ route('admin.studentList') }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
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
                    <th class="whitespace-nowrap">Name</th>
                    <th class="text-center whitespace-nowrap">Mobile Number</th>
                    <th class="text-center whitespace-nowrap">Email Id</th>
                    <th class="text-center whitespace-nowrap">Date of Birth</th>
                    <th class="text-center whitespace-nowrap">City</th>
                    <th class="text-center whitespace-nowrap">Country</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($getStudentList))
            	@foreach($getStudentList as $ck => $sv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td>
	                        <a href="" class="font-medium whitespace-nowrap">{{ $sv->name }}</a> 
	                    </td>
	                    <td class="text-center">{{ $sv->contact_number }}</td>
	                    <td class="text-center">{{ $sv->email }}</td>
	                    <td class="text-center">{{ $sv->dob ? date('d/m/Y',strtotime($sv->dob)) : "-----" }}</td>
	                    <td class="text-center">{{ !is_null($sv->city) ? $sv->city->name : '------'}}</td>
	                    <td class="text-center">{{ !is_null($sv->country) ? $sv->country->name : '------' }}</td>
	                    <td class="w-40">
	                        <input class="form-check-switch ml-auto studentStatus" type="checkbox" @if($sv->is_active == 1) checked="checked" @endif data-id="{{ $sv->uuid }}">
	                    </td>
	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('admin.getStudentProfile',$sv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Profile </a>
	                            <a class="flex items-center mr-3" href="{{ route('admin.editStudent',$sv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
	                            <a class="flex items-center text-theme-6" href="{{ route('admin.deleteStudent',$sv->uuid) }}" onclick="return confirm('Do you want to delete this student ?')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
	                        </div>
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