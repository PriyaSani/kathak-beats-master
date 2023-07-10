@extends('layouts.admin')
@section('title','Batch & workshop List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Batch & workshop List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <form method="post" action="{{ route('admin.saveAttendance') }}">  
        <table class="table table-report -mt-2" id="userAttendance">
            <thead>
                <tr>
                    <th class="text-center whitespace-nowrap">Student Name</th>
                    <th class="text-center whitespace-nowrap">
                        <input class="form-check-switch ml-auto checkAllUser" type="checkbox">
                    </th>
                </tr>
            </thead>
            
            @csrf
            <input type="hidden" value="{{ $getDetails->id }}" name="attendance_id">
            <input type="hidden" value="{{ $getDetails->workshop->uuid }}" name="uuid">
            <input type="hidden" value="{{ $getDetails->workshop->id }}" name="workshop_id">
            
            <tbody>
            @if(!is_null($getStudent))
            	@foreach($getStudent as $fk => $fv)
	                <tr class="intro-x">
	                    <td class="text-center">
	                        <a href="" class="font-medium whitespace-nowrap">{{ $fv->users->name }}</a> 
	                    </td>
                        <td class="text-center">
                            <input class="form-check-switch ml-auto users" type="checkbox" name="user_id[]" value="{{ $fv->student_id }}">
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
@section('js')
<script type="text/javascript">
    $(document).on('change','.checkAllUser',function(){
        if(this.checked){
            $('.users').attr('checked',true)
        } else {
            $('.users').attr('checked',false)
        }
    });
</script>
@endsection