@extends('layouts.admin')
@section('title','Course List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Course List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="whitespace-nowrap">Sr. No</th>
                    <th class="text-center whitespace-nowrap">Content Type</th>
                    <th class="text-center whitespace-nowrap">Title</th>
                    <th class="text-center whitespace-nowrap">Linked To</th>
                    <th class="text-center whitespace-nowrap">Added on</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($getCourse))
            	@foreach($getCourse as $fk => $fv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td class="text-center">{{ $type[$fv->course_type] }}</td>
	                    <td class="text-center">{{ $fv->title ? $fv->title : '-------' }}</td>
                        <td class="text-center">{{ count($fv->workshop ) }}</td>
                        <td class="text-center">{{ date('d/m/Y',strtotime($fv->created_at)) }}</td>
	                    <td class="w-40 text-center">
	                        <input class="form-check-switch ml-auto courseStatus" type="checkbox" @if($fv->is_active == 1) checked="checked" @endif data-id="{{ $fv->course->uuid }}">
	                    </td>
	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('admin.editCourse',base64_encode($fv->id)) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <a class="flex items-center text-theme-6" href="{{ route('admin.deleteCourse',base64_encode($fv->id)) }}" onclick="return confirm('Do you want to delete this course ?')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
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