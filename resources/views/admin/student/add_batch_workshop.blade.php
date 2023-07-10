@extends('layouts.admin')
@section('title','Workshop List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Workshop List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <form method="post" action="{{ route('admin.saveLinkedWorkshop') }}">  
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="text-center whitespace-nowrap">Select Workshop</th>
                    <th class="text-center whitespace-nowrap">Title</th>
                </tr>
            </thead>
            
                @csrf
                <input type="hidden" name="student_id" value="{{ $getStudentDetails->id }}">
                <input type="hidden" name="uuid" value="{{ $getStudentDetails->uuid }}">
            <tbody>
            @if(!is_null($workshop))
            	@foreach($workshop as $fk => $fv)
	                <tr class="intro-x">
	                	<td class="text-center">
                            <input type="checkbox" name="workshop_id[]" value="{{ $fv->id }}" />
                        </td>
	                    <td class="text-center">
	                        <a href="" class="font-medium whitespace-nowrap">{{ $fv->title }}</a> 
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