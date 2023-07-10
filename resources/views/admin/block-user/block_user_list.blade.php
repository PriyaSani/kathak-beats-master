@extends('layouts.admin')
@section('title','Block User List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Block User List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">
    
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <table class="table table-report -mt-2" id="table_id">
            <thead>
                <tr>
                	<th class="whitespace-nowrap">Sr. No</th>
                    <th class="whitespace-nowrap">Name</th>
                    <th class="whitespace-nowrap">Email</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($user))
            	@foreach($user as $fk => $fv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td>{{ $fv->name }}</td>
                        <td>{{ $fv->email }}</td>
	                    
	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
	                            <a class="flex items-center btn btn-danger mr-3" onclick="return confirm('Are you sure want to unblock this user?')" href="{{ route('admin.unblockUser',$fv->uuid) }}"> 
                                    Unblock 
                                </a>
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