@extends('layouts.admin')
@section('title','Video List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Video List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">

	 <div class="intro-y box col-span-12 lg:col-span-12">
        <div class="p-5">
            <form method="post" action="{{ route('admin.videoList') }}">  
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
                        <label>Grid Type</label>
                        <select class="form-control menulist col-span-3" name="grid_type" id="grid_type" data-msg="Select Status" >
                            <option value="">Select Grid Type</option>
                            <option value="1" @if($gridType == 1) selected="selected" @endif>Full View</option>
                            <option value="2" @if($gridType == 2) selected="selected" @endif>60-40 View</option>
                            <option value="2" @if($gridType == 3) selected="selected" @endif>40-60 View</option>
                        </select>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                @if($filter == 1)
                    <a href="{{ route('admin.videoList') }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
                @endif
            </form>
        </div>
    </div>
    
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="whitespace-nowrap">Sr. No</th>
                	<th class="text-center whitespace-nowrap">Title</th>
                    <th class="whitespace-nowrap">Image</th>
                    <th class="whitespace-nowrap">Grid Type</th>
                    <th class="text-center whitespace-nowrap">Priority</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($getVideo))
            	@foreach($getVideo as $fk => $fv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                	<td class="text-center">
                            {{ $fv->video_title_one }}
                        </td>
	                    <td class="text-center">
	                        <div class="flex">
	                            <div class="w-10 h-10 image-fit zoom-in">
	                                <img class="tooltip rounded-full" src="{{ Config::get('constants.awsUrl') }}/video/{{ $fv->video_thumbnail_one }}" title="{{ $fv->video_title_one }}"/>
	                            </div>
	                        </div>
	                    </td>
	                    <td>
	                        <a href="" class="font-medium whitespace-nowrap">{{ $grid[$fv->grid_type] }}</a> 
	                    </td>
	                    <td class="text-center">
                            {{ $fv->priority }}
                        </td>
	                    <td class="text-center">
	                        <input class="form-check-switch ml-auto videoStatus" type="checkbox" @if($fv->is_active == 1) checked="checked" @endif data-id="{{ $fv->uuid }}">
	                    </td>
	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
	                            <a class="flex items-center mr-3" href="{{ route('admin.editVideo',$fv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
	                            <a class="flex items-center text-theme-6" href="{{ route('admin.deleteVideo',$fv->uuid) }}" onclick="return confirm('Do you want to delete this video ?')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
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