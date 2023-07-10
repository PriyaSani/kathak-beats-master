@extends('layouts.admin')
@section('title','Edit Workshop & Batches')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
       Edit Workshop & Batches
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-12 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                   Edit Workshop & Batches
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedWorkshop') }}" method="post" id="addWorkshop" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $workshop->id}}" />

                    <div class="mt-3">
                        <label>Engagement Type<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="engagement_type" id="engagement_type" data-msg="Select engagement type" required>
                            <option value="">Select Engagement Type</option>
                            <option value="1" @if($workshop->engagement_type == 1) selected="selected" @endif>Batch</option>
                            <option value="2" @if($workshop->engagement_type == 2) selected="selected" @endif>Workshop</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Engagement Mode<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="engagement_mode" id="engagement_mode" data-msg="Select engagement mode" required>
                            <option value="">Select Engagement Mode</option>
                            <option value="1" @if($workshop->engagement_mode == 1) selected="selected" @endif>Studio</option>
                            <option value="2" @if($workshop->engagement_mode == 2) selected="selected" @endif>Online</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Title<span class="mandatory">*</span></label>
                        <input type="text" name="title" class="input w-full border form-control mt-2" data-msg="Enter title" value="{{ $workshop-> title}}" placeholder="Title" required/>
                    </div>

                    <!-- poster -->
                    <div class="mt-3">
                        <label>Poster<span class="mandatory">*</span></label>
                        <input type="file" name="poster" class="dropify form-control" data-msg="Upload batch poster" data-default-size="5M" data-default-file="{{ Config::get('constants.awsUrl') }}/poster/{{ $workshop->poster }}" />
                    </div>

                    
                    <div class="mt-3">
                        <label>Short Description<span class="mandatory">*</span></label>
                        <textarea type="text" name="short_description" class="input w-full border form-control mt-2" placeholder="Short Description" id="shortDescription" data-msg="Enter short description" required>{{ $workshop->description }}</textarea>
                        <span id='remainingC' class="floatright">Remaining characters : 150</span>
                    </div>

                    <div class="mt-3">
                        <label>Price<span class="mandatory">*</span></label>
                        <input type="text" name="price" class="input w-full border form-control mt-2 numeric" placeholder="Price Per Month" value="{{ $workshop->price }}" data-msg="Enter price" required/>
                    </div>

                    <div class="mt-3">
                        <label>About Class<span class="mandatory">*</span></label>
                        <textarea type="text" name="about" data-simple-toolbar="true" class="input w-full border ckeditor form-control mt-2 editor1" placeholder="About Class" id="aboutClass" maxlength="550" required>{{ $workshop->about }}</textarea>
                        <span id="about"></span>
                    </div>

                    <div class="mt-3">
                        <label>Contents of the Class<span class="mandatory">*</span></label>
                        <textarea type="text" name="content" data-simple-toolbar="true" class="input w-full border ckeditor form-control mt-2 editor2" placeholder="Contents of the Class" id="classContent" data-length="1400" maxlength="1400" required>{{ $workshop->content }}</textarea>
                        <span id="content"></span>
                    </div>
                    
                    <div class="mt-3">
                        <label>Instructor<span class="mandatory">*</span></label>
                        <select data-placeholder="Select Instructor" name="instuctor[]" id="selectInstructor" data-search="true" class="tail-select w-full selectInstructor" data-msg="Select instructor" required multiple>
                            @if(!is_null($getFacultyList))
                                @foreach($getFacultyList as $fk => $fv)
                                    <option value="{{ $fv->id }}" @if(in_array($fv->id,$faculty)) selected="selected" @endif>{{ $fv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span id="instuctor"></span>
                    </div>

                    <div class="mt-3 @if($workshop->engagement_mode != 1) hide @endif studio_batch">
                        <label>Studio<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full studio_batch" name="studio" @if($workshop->engagement_mode == 1) required @endif>
                            <option value="">Select Studio</option>
                            @if(!is_null($studio))
                                @foreach($studio as $sk => $sv)
                                    <option value="{{ $sv->id }}" @if($workshop->studio_id == $sv->id) selected="selected" @endif>{{ $sv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3 @if($workshop->engagement_type == 2) hide  @endif batch">
                        <label>Actual Start date</label>
                        <input class="ndatepicker form-control input w-full form-control border mt-2 batch" name="actual_start_date" @if($workshop->actual_start_date != '') value="{{ date('d/m/Y',strtotime($workshop->actual_start_date)) }}" @endif autocomplete="off" >
                    </div>


                    <div class="mt-3 @if($workshop->engagement_type == 2) hide  @endif batch">
                        <label>Start date<span class="mandatory">*</span></label>
                        <input class="ndatepicker form-control input w-full form-control border mt-2" id="start_date" name="start_date" data-single-mode="true" placeholder="dd/mm/yyyy"  value="{{ date('d/m/Y',strtotime($workshop->start_date)) }}" data-msg="Select start date">
                    </div>

                    <div class="mt-3 @if($workshop->engagement_type == 2) hide  @endif batch">
                        <label>End Date<span class="mandatory">*</span></label>
                        <input class="ndatepicker form-control input w-full form-control border mt-2" id="end_date" name="end_date" data-single-mode="true" placeholder="dd/mm/yyyy"  value="{{ date('d/m/Y',strtotime($workshop->end_date)) }}" data-msg="Select end date">
                    </div>

                    <div class="mt-3 @if($workshop->engagement_type == 2) hide  @endif batch">
                        <label>Frequency<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="frequency" id="frequency">
                            <option value="">Select Frequency</option>
                            <option value="1"@if($workshop->frequency == 1) selected="selected" @endif>1</option>
                            <option value="2"@if($workshop->frequency == 2) selected="selected" @endif>2</option>
                            <option value="3"@if($workshop->frequency == 3) selected="selected" @endif>3</option>
                            <option value="4"@if($workshop->frequency == 4) selected="selected" @endif>4</option>
                            <option value="5"@if($workshop->frequency == 5) selected="selected" @endif>5</option>
                            <option value="6"@if($workshop->frequency == 6) selected="selected" @endif>6</option>
                            <option value="7"@if($workshop->frequency == 7) selected="selected" @endif>7</option>
                        </select>
                    </div>

                    @php
                        
                        $datetime1 = date_create($workshop->start_date);
                        $datetime2 = date_create($workshop->end_date);
                        $interval = date_diff($datetime1, $datetime2);
                        $diff = $interval->format('%d');

                        $timeTable = array();

                        if($workshop->engagement_type == 2){
                            if(!is_null($workshop->timetable)){
                                foreach($workshop->timetable as $tk => $tv){
                                    $timeTable[$tv->date]['start_time'] = $tv->start_time;
                                    $timeTable[$tv->date]['end_time'] = $tv->end_time;
                                }
                            }
                        }
                                   
                    @endphp

                    <div class="mt-3 @if($workshop->engagement_type == 1) hide  @endif workshop">
                        <label>Workshop Date Range</label>
                        <input data-daterange="true" class="datepicker form-control w-full block mx-auto daterange" name="daterange">
                    </div>       

                    <div class="mt-3">
                        <div class="form-check">
                            <label class="form-check-label" for="checkbox-switch-7">Booking</label>&nbsp;&nbsp;&nbsp;
                            <input class="form-check-switch" name="booking" type="checkbox" id="checkbox-switch-7" @if($workshop->booking == 1) checked="checked" @endif>
                        </div>
                    </div>                 
                    
                    <div class="mt-3 workshop-table @if($workshop->engagement_type == 1) hide  @endif">
                        <label>Workshop Time Table</label>
                        <table class="table">
                            <thead>
                                <tr>
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th> 
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Sr No.</th> 
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Date</th> 
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Start time</th> 
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">End time</th> 
                                </tr>
                            </thead>
                            <tbody class="workshop-tbody">
                                @for($i = 0;$i <= $diff; $i++)
                                    @php $date = date('Y-m-d',strtotime('+'.$i.' days')); @endphp
                                    <tr>
                                        <td class="border">
                                            <input type="checkbox" name="data[{{ $i }}][select_date]" class="workshop_range" data-id="{{ $i }}" @if(array_key_exists($date,$timeTable)) checked @endif />
                                        </td>
                                        <td class="border">
                                            {{ $i + 1 }}
                                        </td>
                                        <td class="border">
                                            <input type="text" name="data[{{ $i }}][date]" class="form-control"  value="{{ date('d/m/Y',strtotime($date)) }}" readonly value="" />
                                        </td>
                                        <td class="border">
                                            <input type="time" name="data[{{ $i }}][start_time]" class="form-control start_time_{{ $i }}" @if(array_key_exists($date,$timeTable)) value="{{ $timeTable[$date]['start_time'] }}" required @else readonly @endif data-id="{{ $i }}" >
                                        </td>
                                        <td class="border">
                                            <input type="time" name="data[{{ $i }}][end_time]" class="form-control time end_time_{{ $i }}" @if(array_key_exists($date,$timeTable)) value="{{ $timeTable[$date]['end_time'] }}" required @else readonly @endif  data-id="{{ $i }}" >
                                        </td>
                                    </tr>
                                @endfor
                               
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 batch-table @if($workshop->engagement_type == 2) hide  @endif">
                        <table class="table">
                            <label><b>Batch Time Table</b></label>
                            <thead>
                                <tr>
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Sr No.</th> 
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Day</th> 
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Start time</th> 
                                   <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">End time</th> 
                                </tr>
                            </thead>
                            <tbody class="batch-tbody">
                                @if($workshop->engagement_type == 1)
                                    @if(!is_null($workshop->timetable)) 
                                        @foreach($workshop->timetable as $tk => $tv)
                                            <tr>
                                                <td class="border">{{ $tk + 1}}</td>
                                                <td class="border">
                                                    <select class="form-control menulist" name="data[{{ $tk }}][day]" required>
                                                        <option value="1"@if($tv->day_id == 1) selected="selected" @endif>Sunday</option>
                                                        <option value="2"@if($tv->day_id == 2) selected="selected" @endif>Monday</option>
                                                        <option value="3"@if($tv->day_id == 3) selected="selected" @endif>Tuesday</option>
                                                        <option value="4"@if($tv->day_id == 4) selected="selected" @endif>Wednesday</option>
                                                        <option value="5"@if($tv->day_id == 5) selected="selected" @endif>Thrusday</option>
                                                        <option value="6"@if($tv->day_id == 6) selected="selected" @endif>Friday</option>
                                                        <option value="7"@if($tv->day_id == 7) selected="selected" @endif>Saturday</option>
                                                    </select>
                                                </td>
                                                <td class="border"><input type="time" name="data[{{ $tk }}][start_time]" class="form-control time start_time_{{ $tk }}" value="{{ $tv->start_time }}" data-id="{{ $tk }}" required></td>
                                                <td class="border"><input type="time" name="data[{{ $tk }}][end_time]" class="form-control" value="{{ $tv->end_time }}" data-id="{{ $tk }}" required></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary w-24 mr-1 mb-2 mt-4" name="btn_submit" value="list">Update</button>

                    <a href="{{ route('admin.workshopList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection
