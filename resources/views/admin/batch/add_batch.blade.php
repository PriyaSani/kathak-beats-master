@extends('layouts.admin')
@section('title','Add Workshop & Batches')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Add Workshop & Batches
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-12 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Add Workshop & Batches
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveWorkshop') }}" method="post" id="addWorkshop" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-3">
                        <label>Engagement Type<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="engagement_type" id="engagement_type" required>
                            <option value="">Select Engagement Type</option>
                            <option value="1">Batch</option>
                            <option value="2">Workshop</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Engagement Mode<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="engagement_mode" id="engagement_mode" required>
                            <option value="">Select Engagement Mode</option>
                            <option value="1">Studio</option>
                            <option value="2">Online</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Title<span class="mandatory">*</span></label>
                        <input type="text" name="title" class="input w-full border form-control mt-2" placeholder="Title" required/>
                    </div>

                    <!-- poster -->
                    <div class="mt-3">
                        <label>Poster<span class="mandatory">*</span></label>
                        <input type="file" name="poster" class="dropify form-control" data-max-file-size="5M" required data-msg="Upload poster" />
                    </div>

                    
                    <div class="mt-3">
                        <label>Short Description<span class="mandatory">*</span></label>
                        <textarea type="text" name="short_description" class="input w-full border form-control mt-2" placeholder="Short Description" id="shortDescription" maxlength="150" required></textarea>
                        <span id='remainingC' class="floatright">Remaining characters : 150</span>
                    </div>

                    <div class="mt-3">
                        <label>Price<span class="mandatory">*</span></label>
                        <input type="text" name="price" class="input w-full border form-control mt-2 numeric" placeholder="Price Per Month" required/>
                    </div>

                    <div class="mt-3">
                        <label>About Class<span class="mandatory">*</span></label>
                        <textarea type="text" name="about" class="input w-full border ckeditor form-control mt-2 editor1" placeholder="About Class" id="aboutClass" maxlength="550" required></textarea>
                        <span id="about"></span>
                    </div>

                    <div class="mt-3">
                        <label>Contents of the Class<span class="mandatory">*</span></label>
                        <textarea type="text" name="content" data-simple-toolbar="true" class="input w-full border ckeditor form-control mt-2 editor2" placeholder="Contents of the Class" id="classContent" data-length="1400" maxlength="1400" required></textarea>
                        <span id="content"></span>
                    </div>

                    <div class="mt-3">
                        <label>Instructor<span class="mandatory">*</span></label>
                        <select data-placeholder="Select Instructor" name="instuctor[]" id="selectInstructor" data-search="true" data-multilimit="3" class="select2 menulist w-full selectInstructor" required multiple>
                            @if(!is_null($getFacultyList))
                                @foreach($getFacultyList as $fk => $fv)
                                    <option value="{{ $fv->id }}">{{ $fv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span id="instuctor"></span>
                    </div>

                    <div class="mt-3 hide studio_batch">
                        <label>Studio<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full studio_batch" name="studio" >
                            <option value="">Select Studio</option>
                            @if(!is_null($studio))
                                @foreach($studio as $sk => $sv)
                                    <option value="{{ $sv->id }}">{{ $sv->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3 hide batch">
                        <label>Actual Start date</label>
                        <input class="ndatepicker form-control input w-full form-control border mt-2" name="actual_start_date" placeholder="dd/mm/yyyy" autocomplete="off" >
                    </div>

                    <div class="mt-3 hide batch">
                        <label>Start date<span class="mandatory">*</span></label>
                        <input class="ndatepicker form-control input w-full form-control border mt-2 batch" id="start_date" name="start_date" placeholder="dd/mm/yyyy" autocomplete="off" >
                    </div>

                    <div class="mt-3 hide batch">
                        <label>End Date<span class="mandatory">*</span></label>
                        <input class="ndatepicker form-control input w-full form-control border mt-2 batch" id="end_date" name="end_date" placeholder="dd/mm/yyyy" autocomplete="off" >
                    </div>

                    <div class="mt-3 hide batch">
                        <label>Frequency<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full batch" name="frequency" id="frequency">
                            <option value="">Select Frequency</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </div>

                    <div class="mt-3 hide workshop">
                        <label>Workshop Date Range</label>
                        <input data-daterange="true" class="datepicker form-control w-full block mx-auto daterange workshop" name="daterange">
                    </div>        

                    <div class="mt-3">
                        <div class="form-check">
                            <label class="form-check-label" for="checkbox-switch-7">Booking</label>&nbsp;&nbsp;&nbsp;
                            <input class="form-check-switch" name="booking" type="checkbox" id="checkbox-switch-7" checked="checked">
                        </div>
                    </div>                 
                    
                    <div class="mt-3 workshop-table hide">
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
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 batch-table hide">
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

                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Save</button>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="save_and_add_new" >Save & Add New</button>

                    <a href="{{ route('admin.workshopList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection
