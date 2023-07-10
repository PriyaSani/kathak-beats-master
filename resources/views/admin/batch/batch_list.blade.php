@extends('layouts.admin')
@section('title','Workshop & Batches List')
@section('content')
<!-- END: Top Bar -->
<h2 class="intro-y text-lg font-medium mt-10">
    Workshop & Batches List
</h2>
<div class="grid grid-cols-12 gap-6 mt-5">

    <div class="intro-y box col-span-12 lg:col-span-12">
        <div class="p-5">
            <form method="post" action="{{ route('admin.workshopList') }}">  
                @csrf
                <div class="grid grid-cols-3 gap-2 mt-5">
                    <div class="mt-3">
                        <label>Engagement Type</label>
                        <select class="form-control menulist col-span-3" name="engagement_type" id="engagement_type" data-msg="Select engagement type" >
                            <option value="">Select Engagement Type</option>
                            <option value="1" @if($engagement_type == 1) selected="selected" @endif>Batch</option>
                            <option value="2" @if($engagement_type == 2) selected="selected" @endif>Workshop</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label>Engagement Mode</label>
                        <select class="form-control menulist col-span-3" name="engagement_mode" data-msg="Select engagement mode" >
                            <option value="">Select Engagement Mode</option>
                            <option value="1" @if($engagement_mode == 1) selected="selected" @endif>Studio</option>
                            <option value="2" @if($engagement_mode == 2) selected="selected" @endif>Online</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Engagement Status</label>
                        <select class="form-control menulist col-span-3" name="engagement_status" data-msg="Select engagement mode" >
                            <option value="">Select Engagement Status</option>
                            <option value="1" @if($engagement_status == 1) selected="selected" @endif>Active</option>
                            <option value="2" @if($engagement_status == 2) selected="selected" @endif>Inactive</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Booking Status</label>
                        <select class="form-control menulist col-span-3" name="booking_status" data-msg="Select engagement mode" >
                            <option value="">Select Booking Status</option>
                            <option value="1" @if($booking_status == 1) selected="selected" @endif>Active</option>
                            <option value="2" @if($booking_status == 2) selected="selected" @endif>Inactive</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Frequency / Week</label>
                        <select class="form-control menulist col-span-3" name="frequency" data-msg="Select engagement mode" >
                            <option value="">Frequency / Week</option>
                            <option value="1" @if($frequency == 1) selected="selected" @endif>1</option>
                            <option value="2" @if($frequency == 2) selected="selected" @endif>2</option>
                            <option value="3" @if($frequency == 3) selected="selected" @endif>3</option>
                            <option value="4" @if($frequency == 4) selected="selected" @endif>4</option>
                            <option value="5" @if($frequency == 5) selected="selected" @endif>5</option>
                            <option value="6" @if($frequency == 6) selected="selected" @endif>6</option>
                            <option value="7" @if($frequency == 7) selected="selected" @endif>7</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Start Date Range</label>
                        <input data-daterange="true" class="datepicker form-control w-full block mx-auto col-span-3 daterange" name="start_daterange" value="{{ $startDateRange }}" placeholder="Start Date Range">
                    </div>

                    <div class="mt-3">
                        <label>End Date Range</label>
                        <input data-daterange="true" class="datepicker form-control w-full block mx-auto col-span-3 daterange" name="end_daterange" value="{{ $endDateRange }}" placeholder="End Date Range">
                    </div>

                    <div class="mt-3">
                        <label>Instructor</label><br>
                        <select name="instuctor" data-search="true" class="tail-select w-full col-span-4 ml-auto">
                            <option value="">Select Instructor</option>
                            @if(!is_null($getFacultyList))
                                @foreach($getFacultyList as $fk => $fv)
                                    <option value="{{ $fv->id }}" @if($fv->id == $instuctor) selected="selected" @endif>{{ $fv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Studio</label><br>
                        <select data-search="true" class="tail-select col-span-4 w-full ml-auto" name="studio_type">
                            <option value="">Select Studio</option>
                            @if(!is_null($studio))
                                @foreach($studio as $sk => $sv)
                                    <option value="{{ $sv->id }}" @if($sv->id == $studio_type) selected="selected" @endif>{{ $sv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Minimum Participants</label><br>
                        <input type="number" class="form-control input col-span-3" name="min_student" placeholder="Minimum Participants" value="{{ $min_student}}">
                    </div>

                    <div class="mt-3">
                        <label>Maximum  Participants</label><br>
                        <input type="number" class="form-control input col-span-3" name="max_student" placeholder="Maximum  Participants" value="{{ $max_student}}">
                    </div>

                    <div class="mt-3">
                        <label>Minimum Price</label><br>
                        <input type="number" class="form-control input col-span-3" name="min_price" placeholder="Minimum Price" value="{{ $min_price}}">
                    </div>

                    <div class="mt-3">
                        <label>Maximum Price</label><br>
                        <input type="number" class="form-control input col-span-3" name="max_price" placeholder="Maximum Price" value="{{ $max_price}}">
                    </div>
                    

                </div>
                <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Filter</button>
                @if($filter == 1)
                    <a href="{{ route('admin.workshopList') }}" class="btn btn-danger w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Reset</a>
                @endif
            </form>
        </div>
    </div>
    
    <div class="intro-y col-span-12 overflow-auto lg:overflow-hide">
        <table class="table table-report -mt-2 nowrap" id="table_id">
            <thead>
                <tr>
                	<th class="whitespace-nowrap">Sr. No</th>
                    <th class="whitespace-nowrap">Poster</th>
                    <th class="whitespace-nowrap">Title</th>
                    <th class="text-center whitespace-nowrap">Engagement Type</th>
                    <th class="text-center whitespace-nowrap">Engagement Mode</th>
                    <!-- <th class="text-center whitespace-nowrap">No of Participants</th> -->
                    <th class="text-center whitespace-nowrap">Price Per Month</th>
                    <th class="text-center whitespace-nowrap">Instructor(s)</th>
                    <th class="text-center whitespace-nowrap">Frequency / Week</th>
                    <th class="text-center whitespace-nowrap">Time</th>
                    <th class="text-center whitespace-nowrap">Studio</th>
                    <th class="text-center whitespace-nowrap">Start Date</th>
                    <th class="text-center whitespace-nowrap">End Date</th>
                    <th class="text-center whitespace-nowrap">Booking Status</th>
                    <th class="text-center whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
            @if(!is_null($workshopList))
            	@foreach($workshopList as $fk => $fv)
	                <tr class="intro-x">
	                	<td class="text-center">{{ $loop->iteration }}</td>
	                    <td class="w-40">
	                        <div class="flex">
	                            <div class="w-10 h-10 image-fit zoom-in">
	                                <img alt="{{ $fv->title }}" class="rounded-full" src="{{ Config::get('constants.awsUrl') }}/poster/{{ $fv->poster }}" title="{{ $fv->name }}">
	                            </div>
	                        </div>
	                    </td>
	                    <td>
	                        <a href="" class="font-medium whitespace-nowrap">{{ $fv->title }}</a> 
	                    </td>
	                    <td class="text-center">{{ $fv->engagement_type == 1 ? 'Batch' : 'Workshop'}}</td>
	                    <td class="text-center">{{ $fv->engagement_mode == 1 ? 'Studio' : 'Online' }}</td>
	                    <!-- <td class="text-center">{{ $fv->workshopstudent_count }}</td> -->
	                    <td class="text-center">{{ $fv->price }}</td>
	                    <td class="text-center">
                            <?php $faculty = array(); ?>
                            @if(!is_null($fv->workshopfaculty))
                                @foreach($fv->workshopfaculty as $wk => $wv)
                                    @if(!is_null($wv->faculty))
                                        <?php $faculty[] = $wv->faculty->name; ;?>
                                    @endif
                                @endforeach
                            @endif
                            {{ count($faculty) > 0 ? implode(' | ',$faculty) : '--' }}
                        </td>
                        <td class="text-center">
                            {{ $fv->frequency ? $fv->frequency  : '----'}} 
                        </td>
                        <td class="text-center">
                            @php 
                                $day = array(1 => 'Sunday',2 => 'Monday', 3 => 'Tuesday', 4 => 'Wednesday', 5 => 'Thrusday' , 6 => 'Friday', 7 => 'Saturday');@endphp
                            @if(!is_null($fv->timetable))
                                @foreach($fv->timetable as $tk => $tv)
                                    @if($tv->date != '')
                                        {{ $tv->date }} : {{ $tv->start_time }} - {{ $tv->end_time }} <br />
                                    @else 
                                        {{ $day[$tv->day_id] }} : {{ $tv->start_time }} - {{ $tv->end_time }} <br />                                       
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        @if(!is_null($fv->studio))
                            <td class="text-center">{{ $fv->studio->name }}</td>
                        @else
                            <td class="text-center">---------</td>
                        @endif
                        <td class="text-center">{{ date('d/m/Y',strtotime($fv->start_date)) }}</td>
                        <td class="text-center">{{ date('d/m/Y',strtotime($fv->end_date)) }}</td>
                        <td class="w-40 text-center">
                            <input class="form-check-switch ml-auto bookingStatus" type="checkbox" @if($fv->booking == 1) checked="checked" @endif data-id="{{ $fv->uuid }}">
                        </td>
	                    <td class="w-40 text-center">
	                        <input class="form-check-switch ml-auto batchStatus" type="checkbox" @if($fv->is_active == 1) checked="checked" @endif data-id="{{ $fv->uuid }}">
	                    </td>
	                    <td class="table-report__action w-56">
	                        <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="{{ route('admin.engagementSetting',$fv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Setting </a>
	                            <a class="flex items-center mr-3" href="{{ route('admin.editWorkShop',$fv->uuid) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
	                            <a class="flex items-center text-theme-6" href="{{ route('admin.deleteWorkshop',$fv->uuid) }}" onclick="return confirm('Do you want to delete this workshop ?')"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
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
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').val('');
    });
</script>
@endsection