@extends('layouts.admin')
@section('title','Faculty List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Faculty List
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
            <form method="post" action="{{ route('admin.facultyList') }}">  
                @csrf
                <div class="grid grid-cols-3 gap-2 mt-5">

                    <div class="mt-3">
                        <label>Batches</label>
                        <select name="batch_id" data-search="true" class="form-control menulist col-span-3">
                            <option value="">Select Batches</option>
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
                        <label>Workshop</label>
                        <select name="workshop_id" data-search="true" class="form-control menulist col-span-3" style="margin-right: 15px;">
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

                </div>
                <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                @if($filter == 1)
                    <a href="{{ route('admin.facultyList') }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
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
                    <th class="whitespace-nowrap">Profile Picture</th>
                    <th class="whitespace-nowrap">Name</th>
                    <th class="text-center whitespace-nowrap">Mobile Number</th>
                    <th class="text-center whitespace-nowrap">Email Id</th>
                    <th class="text-center whitespace-nowrap">Date of Birth</th>
                    <th class="text-center whitespace-nowrap">City</th>
                    <th class="text-center whitespace-nowrap">State</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($getFacultyList))
            	@foreach($getFacultyList as $fk => $fv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td class="w-40">
	                        <div class="flex">
	                            <div class="w-10 h-10 image-fit zoom-in">
	                                <img alt="{{ $fv->name }}" class="tooltip rounded-full" src="{{ Config::get('constants.awsUrl') }}/profile/{{ $fv->profile_image }}" title="{{ $fv->name }}">
	                            </div>
	                        </div>
	                    </td>
	                    <td>
	                        <a href="" class="font-medium whitespace-nowrap">{{ $fv->name }}</a> 
	                    </td>
	                    <td class="text-center">{{ $fv->mobile }}</td>
	                    <td class="text-center">{{ $fv->email }}</td>
	                    <td class="text-center">{{ $fv->dob ? date('d/m/Y',strtotime($fv->dob)) : "-----" }}</td>
	                    <td class="text-center">{{ !is_null($fv->city) ? $fv->city->name : '------' }}</td>
	                    <td class="text-center">{{ !is_null($fv->state) ? $fv->state->name : '------'}}</td>
	                    <td class="w-40">
	                        <input class="form-check-switch ml-auto facultyStatus" type="checkbox" @if($fv->is_active == 1) checked="checked" @endif data-id="{{ $fv->uuid }}">
	                    </td>
	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('admin.facultyProfile',$fv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Profile </a>
	                            <a class="flex items-center mr-3" href="{{ route('admin.editFaculty',$fv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
	                            <a class="flex items-center text-theme-6" href="{{ route('admin.deleteFaculty',$fv->uuid) }}" onclick="return confirm('Do you want to delete this faculty ?')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
	                        </div>
	                    </td>
	                </tr>
	            @endforeach
	        @endif
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    
    <!-- END: Pagination -->
</div>
@endsection