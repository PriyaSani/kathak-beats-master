@extends('layouts.admin')
@section('title','Studio List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Studio List
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
    <!-- BEGIN: Data List -->
     <div class="intro-y box col-span-12 lg:col-span-12">
        <div class="p-5">
            <form method="post" action="{{ route('admin.studioList') }}">  
                @csrf
                <div class="grid grid-cols-3 gap-2 mt-5">

                    <div class="mt-3">
                        <label>Status</label>
                        <select class="form-control menulist col-span-3" name="status" id="status" data-msg="Select Status" >
                            <option value="">Status</option>
                            <option value="1" @if($status == 1) selected="selected" @endif>Active</option>
                            <option value="2" @if($status == 2) selected="selected" @endif>Inactive</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Country</label>
                        <select data-search="true" class="form-control menulist col-span-3" name="country_id" id="country_id" >
                            <option value="">Select Country</option>
                            @if(!is_null($country))
                                @foreach($country as $ck => $cv)
                                    <option value="{{ $cv->id }}" @if($cv->id == $countryFilter) selected="selected" @endif>{{ $cv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="mt-3">
                        <label>State</label>
                        <select data-search="true" class="form-control menulist col-span-3" name="state_id" id="state_id" >
                            <option value="">Select State</option>
                            @if(!is_null($state))
                                @foreach($state as $sk => $sv)
                                    <option value="{{ $sv->id }}" @if($sv->id == $stateFilter) selected="selected" @endif>{{ $sv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>City</label>
                        <select data-search="true" class="form-control menulist col-span-3" name="city_id" id="city_id" >
                            <option value="">Select City</option>
                            @if(!is_null($city))
                                @foreach($city as $ck => $cv)
                                    <option value="{{ $cv->id }}" @if($cv->id == $cityFilter) selected="selected" @endif >{{ $cv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                @if($filter == 1)
                    <a href="{{ route('admin.studioList') }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="whitespace-nowrap">Sr. No</th>
                    <th class="whitespace-nowrap">Studio Name</th>
                    <th class="whitespace-nowrap">Address</th>
                    <th class="text-center whitespace-nowrap">City</th>
                    <th class="text-center whitespace-nowrap">State</th>
                    <th class="text-center whitespace-nowrap">Country</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($studio))
            	@foreach($studio as $sk => $sv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td class="text-center">{{ $sv->name }}</td>
	                    <td class="text-center">{{ $sv->address }}</td>
	                    <td class="text-center">{{ $sv->city->name }}</td>
                        <td class="text-center">{{ $sv->state->name }}</td>
	                    <td class="text-center">{{ $sv->country->name }}</td>
	                    <td class="text-center">
	                        <input class="form-check-switch ml-auto studio" type="checkbox" @if($sv->is_active == 1) checked="checked" @endif data-id="{{ $sv->uuid }}">
	                    </td>
	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
	                            <a class="flex items-center mr-3" href="{{ route('admin.editStudio',$sv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
	                            <a class="flex items-center text-theme-6" href="{{ route('admin.deleteStudio',$sv->uuid) }}" onclick="return confirm('Do you want to delete this studio ?')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
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