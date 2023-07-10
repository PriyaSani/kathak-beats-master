@extends('layouts.admin')
@section('title','Student List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Student List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <form method="post" action="{{ route('admin.saveLinkedStudent') }}">  
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="text-center whitespace-nowrap">Select User</th>
                    <th class="text-center whitespace-nowrap">Title</th>
                </tr>
            </thead>
            
                @csrf
                <input type="hidden" name="workshop_id" value="{{ $getWorkshopDetails->id }}">
                <input type="hidden" name="uuid" value="{{ $getWorkshopDetails->uuid }}">
            <tbody>
            @if(!is_null($getStudentList))
            	@foreach($getStudentList as $fk => $fv)
	                <tr class="intro-x">
	                	<td class="text-center">
                            <input type="checkbox" name="student_id[]" value="{{ $fv->id }}" />
                        </td>
	                    <td class="text-center">
	                        <a href="" class="font-medium whitespace-nowrap">{{ $fv->name }}</a> 
	                    </td>
	                </tr>
	            @endforeach
	        @endif
            </tbody>

            
        </table>

        <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Save</button>
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <!-- END: Pagination -->
    </form>
</div>
@endsection