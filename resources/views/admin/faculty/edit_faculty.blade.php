@extends('layouts.admin')
@section('title','Edit Faculty')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Faculty
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Edit Faculty
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedFaculty') }}" method="post" id="editFaculty" enctype="multipart/form-data">

                    @csrf
                    
                    <input type="hidden" name="id" id="id" value="{{ $getFaculty->id }}">

                    <div class="mt-3">
                        <label>Profile Picture<span class="mandatory">*</span></label>
                        <input type="file" name="profile" id="profile" class="dropify form-control" data-default-file="{{ Config::get('constants.awsUrl') }}/profile/{{ $getFaculty->profile_image }}" data-max-file-size="5M" data-msg="" />
                    </div>

                    <div class="mt-3">
                        <label>Full Name<span class="mandatory">*</span></label>
                        <input type="text" name="name" class="input w-full border form-control mt-2" placeholder="Full Name" value="{{ $getFaculty->name }}" required />
                    </div>

                    <div class="mt-3">
                        <label>Address<span class="mandatory">*</span></label>
                        <textarea type="text" name="address" class="input w-full border form-control mt-2" placeholder="Address" required>{{ $getFaculty->address }}</textarea>
                    </div>

                    <div class="mt-3">
                        <label>City<span class="mandatory">*</span></label>
                        <input type="text" name="city" class="input w-full form-control border mt-2 city" placeholder="City"  value="{{ $getFaculty->city->name }}" required/>
                        <input type="hidden" name="city_id" value="{{ $getFaculty->city_id }}" id="city_id">
                    </div>
                    
                   
                    <div class="mt-3">
                        <label>State<span class="mandatory">*</span></label>
                        <input type="text" name="state" class="input w-full form-control border state mt-2" placeholder="State"  value="{{ $getFaculty->state->name }}" required/>
                        <input type="hidden" name="state_id" id="state_id" alue="{{ $getFaculty->state_id }}">
                    </div>

                    <div class="mt-3">
                        <label>Date Of Birth</label>
                        <input class="datepicker form-control input w-full form-control border mt-2" name="dob" data-single-mode="true" value="{{ $getFaculty->dob ? date('d/m/Y',strtotime($getFaculty->dob)) : 'dd/mm/yyyy' }}">
                    </div>

                    <div class="mt-3">
                        <label>Blood Group</label>
                        <select class="tail-select w-full" name="blood_group">
                            <option value="">Select Blood Group</option>
                            @if(!is_null(Config::get('constants.bloodGroup')))
                                @foreach(Config::get('constants.bloodGroup') as $bk => $bv)
                                    <option value="{{ $bk }}" @if($bk == $getFaculty->blood_group) selected="selected" @endif>{{ $bv }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="mt-3">
                        <label>Mobile Number<span class="mandatory">*</span></label>
                        <input type="tel" name="mobile" class="input w-full border form-control mt-2 numeric" placeholder="Mobile Number" value="{{ $getFaculty->mobile }}" maxlength="10" minlength="10" required />
                    </div>

                    <div class="mt-3">
                        <label>Email Id<span class="mandatory">*</span></label>
                        <input type="email" name="email" class="input w-full form-control border mt-2" placeholder="Email Id" value="{{ $getFaculty->email }}" required/>
                    </div>

                    <div class="mt-3">
                        <label>Password</label>
                        <input type="password" name="new_password" class="input w-full form-control border mt-2" placeholder="Password" value="" id="new_password" />
                    </div>

                    <div class="mt-3">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="input w-full form-control border mt-2" placeholder="Confirm Password" />
                    </div>

                    <div class="mt-3">
                        <label>Module<span class="mandatory">*</span></label>
                        <div class="flex flex-col sm:flex-row mt-2">
                            
                            @if(!is_null($modules))
                                @foreach($modules as $mk => $mv)
                                    <div class="form-check mr-2">
                                        <input class="form-check-input" name="module[]" type="checkbox" value="{{ $mv->id }}" id="checkbox-switch-module-{{ $mk }}" @if(in_array($mv->id,$module)) checked="checked" @endif required>
                                        <label class="form-check-label" for="checkbox-switch-module-{{ $mk }}">{{ $mv->name }}</label>
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
                                        <input class="form-check-input" name="dashboard[]" type="checkbox" value="{{ $ek }}" id="checkbox-switch-dash-{{ $ek }}" @if(in_array($ek,$dashboard)) checked="checked" @endif>
                                        <label class="form-check-label" for="checkbox-switch-dash-{{ $ek }}">{{ $ev }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <br />
                        <span id="dashboard"></span>
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4">Update</button>
                    <a href="{{ route('admin.facultyList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection