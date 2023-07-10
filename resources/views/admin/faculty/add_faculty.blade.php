@extends('layouts.admin')
@section('title','Add Faculty')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Add Faculty
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Add Faculty
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveFaculty') }}" method="post" id="addFauclty" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-3">
                        <label>Profile Picture<span class="mandatory">*</span></label>
                        <input type="file" name="profile" id="profile" class="dropify form-control" data-msg="Upload profile picture" data-max-file-size="5M" required/>
                    </div>

                    <div class="mt-3">
                        <label>Full Name<span class="mandatory">*</span></label>
                        <input type="text" name="name" class="input w-full border form-control mt-2" placeholder="Full Name"  required />
                    </div>

                    <div class="mt-3">
                        <label>Address<span class="mandatory">*</span></label>
                        <textarea type="text" name="address" class="input w-full border form-control mt-2" placeholder="Address" required></textarea>
                    </div>

                    <div class="mt-3">
                        <label>City<span class="mandatory">*</span></label>
                        <input type="text" name="city" class="input w-full form-control border mt-2 city" placeholder="City" autocomplete="off" required/>
                        <input type="hidden" name="city_id" value="" id="city_id">
                    </div>
                    
                   
                    <div class="mt-3">
                        <label>State<span class="mandatory">*</span></label>
                        <input type="text" name="state" class="input w-full form-control border mt-2 state" placeholder="State"  autocomplete="off" required/>
                        <input type="hidden" name="state_id" id="state_id">
                    </div>

                    <div class="mt-3">
                        <label>Date Of Birth</label>
                        <input class="datepicker form-control input w-full form-control border mt-2" name="dob" data-single-mode="true" value="dd/mm/yyyy"  data-max-date="{{ date('d/M/Y',strtotime('-1 day')) }}">
                    </div>

                    <div class="mt-3">
                        <label>Blood Group</label>
                        <select class="tail-select w-full" name="blood_group">
                            <option value="">Select Blood Group</option>
                            @if(!is_null(Config::get('constants.bloodGroup')))
                                @foreach(Config::get('constants.bloodGroup') as $bk => $bv)
                                    <option value="{{ $bk }}">{{ $bv }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="mt-3">
                        <label>Mobile Number<span class="mandatory">*</span></label>
                        <input type="tel" name="mobile" class="input w-full border form-control mt-2 numeric" autocomplete="off" placeholder="Mobile Number" value="" maxlength="10" minlength="10" required />
                    </div>

                    <div class="mt-3">
                        <label>Email Id<span class="mandatory">*</span></label>
                        <input type="email" name="email" class="input w-full form-control border mt-2" autocomplete="off" placeholder="Email Id" value="" required/>
                    </div>

                    <div class="mt-3">
                        <label>Password<span class="mandatory">*</span></label>
                        <input type="password" name="new_password" class="input w-full form-control border mt-2" placeholder="Password" value="" id="new_password" required/>
                    </div>

                    <div class="mt-3">
                        <label>Confirm Password<span class="mandatory">*</span></label>
                        <input type="password" name="confirm_password" class="input w-full form-control border mt-2" placeholder="Confirm Password" required/>
                    </div>
                    
                    <div class="mt-3">
                        <label>Module<span class="mandatory">*</span></label>
                        <div class="flex flex-col sm:flex-row mt-2">
                            
                            @if(!is_null($modules))
                                @foreach($modules as $mk => $mv)
                                    <div class="form-check mr-2">
                                        <input class="form-check-input" name="module[]" type="checkbox" value="{{ $mv->id }}" id="checkbox-switch-4" required>
                                        <label class="form-check-label" for="checkbox-switch-4">{{ $mv->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div><br />
                        <span id="module"></span>
                    </div>

                    <div class="mt-3">
                        <label>Dashboard Elements</label>
                        <div class="flex flex-col sm:flex-row mt-2">
                            
                            @if(!is_null(Config::get('constants.dashBoardElements')))
                                @foreach(Config::get('constants.dashBoardElements') as $ek => $ev)
                                    <div class="form-check mr-2">
                                        <input class="form-check-input" name="dashboard[]" type="checkbox" value="{{ $ek }}" id="checkbox-switch-4">
                                        <label class="form-check-label" for="checkbox-switch-4">{{ $ev }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div><br />
                         <span id="dashboard"></span>
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Save</button>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="save_and_add_new" >Save & Add New</button>

                    <a href="{{ route('admin.facultyList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection