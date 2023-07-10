@extends('layouts.admin')
@section('title','Edit Student')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Student
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Edit Student
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedStudent') }}" method="post" id="addStudent" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $getStudent->id }}" id="id">

                    <div class="mt-3">
                        <label>Profile Picture<span class="mandatory">*</span></label>
                        <input type="file" name="profile" id="profile" class="dropify form-control" data-msg="Upload profile picture" data-max-file-size="5M" data-default-file="{{ Config::get('constants.awsUrl') }}/student/{{ $getStudent->profile_image }}" data-msg="" />
                    </div>

                    <div class="mt-3">
                        <label>Full Name<span class="mandatory">*</span></label>
                        <input type="text" name="name" class="input w-full border form-control mt-2" placeholder="Full Name"  value="{{ $getStudent->name }}" required />
                    </div>

                    <div class="mt-3">
                        <label>Email Id<span class="mandatory">*</span></label>
                        <input type="email" name="email" class="input w-full form-control border mt-2" autocomplete="off" placeholder="Email Id" value="{{ $getStudent->email }}" required/>
                    </div>

                    @php $country = \App\Models\Country::all(); @endphp

                    <div class="mt-3 mb-2">
                        <div  style="width: 23%;float:left;">
                            <label>Country Code<span class="mandatory">*</span></label>
                            <select class="form-control menulist w-full" name="country_code" id="country_code" required>
                                <option value="">Select Country Code</option>
                                @if(!is_null($country))
                                    @foreach($country as $ck => $cv)
                                        @if($cv->country_code != '')
                                            <option value="{{ $cv->country_code }}" @if($cv->country_code == $getStudent->country_code) selected="selected" @endif>{{ $cv->country_code }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div  style="width: 75%;float:right">
                            <label>Contact Number<span class="mandatory">*</span></label>
                            <input type="tel" name="mobile" class="input w-full border form-control  numeric" autocomplete="off" placeholder="Contact Number" value="{{ $getStudent->contact_number }}" id="mobile" required />
                        </div>
                    </div><br /><br /><br />

                    <div class="mt-3 mb-2">
                        <div  style="width: 23%;float:left;">
                            <label>Country Code<span class="mandatory">*</span></label>
                            <select class="form-control menulist w-full mt-2" name="country_code_whatsapp" id="wp_country_code" required>
                                <option value="">Select Country Code</option>
                                @if(!is_null($country))
                                    @foreach($country as $ck => $cv)
                                        @if($cv->country_code != '')
                                            <option value="{{ $cv->country_code }}" @if($cv->country_code == $getStudent->country_code_whatsapp) selected="selected" @endif>{{ $cv->country_code }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div  style="width: 75%;float:right">
                            <label>Whatsapp Number<span class="mandatory">*</span><span style="float:right"><input class="form-check-input wpSameNo" type="checkbox" value="" id="vertical-form-3" @if($getStudent->contact_number == $getStudent->wp_number) checked="checked" @endif><label class="form-check-label" for="vertical-form-3">Same as Contact Number</label></span></label>
                            <input type="tel" name="wp_number" id="wp_number" class="input w-full border form-control mt-2 numeric" autocomplete="off" placeholder="Whatsapp Number" value="{{ $getStudent->wp_number }}" id="mobile" required />
                        </div>
                    </div><br /><br /><br />

                    <div class="mt-3">
                        <label>Date Of Birth</label>
                        <input class="datepicker form-control input w-full form-control border mt-2" name="dob" data-single-mode="true" value="{{ $getStudent->dob ? date('d/m/Y',strtotime($getStudent->dob)) : 'dd/mm/yyyy' }}" placeholder="Date Of Birth">
                    </div>

                    @php $country = \App\Models\Country::all(); @endphp
                    <div class="mt-3">
                        <label>Country<span class="mandatory">*</span></label>
                        <select class="form-control" name="country_id" id="country_id">
                            <option value="">Select Country</option>
                            @if(!is_null($country))
                                @foreach($country as $ck => $cv)
                                    <option value="{{ $cv->id }}" @if($cv->id == $getStudent->country_id) selected="selected" @endif>
                                        {{ $cv->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    @php $state = \App\Models\State::where('country_id',$getStudent->country_id)->get(); @endphp
                    <div class="mt-3">
                        <label>State<span class="mandatory">*</span></label>
                        <select class="form-control" name="state_id" id="state_id">
                            <option value="">Select State</option>
                             @if(!is_null($state))
                                @foreach($state as $ck => $cv)
                                    <option value="{{ $cv->id }}" @if($cv->id == $getStudent->state_id) selected="selected" @endif>
                                        {{ $cv->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    @php $city = \App\Models\City::where('state_id',$getStudent->state_id)->get(); @endphp
                    <div class="mt-3">
                        <label>City<span class="mandatory">*</span></label>
                        <select class="form-control" name="city_id" id="city_id">
                            <option value="">Select City</option>
                            @if(!is_null($city))
                                @foreach($city as $ck => $cv)
                                    <option value="{{ $cv->id }}" @if($cv->id == $getStudent->city_id) selected="selected" @endif>
                                        {{ $cv->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    
                    <div class="mt-3">
                        <label>Full Address<span class="mandatory">*</span></label>
                        <textarea type="text" name="address" class="input w-full border form-control mt-2" placeholder="Full Address" required>{{ $getStudent->address }}</textarea>
                    </div>
                    

                    <div class="mt-3">
                        <label>Billing Cycle<span class="mandatory">*</span></label>
                        <select class="tail-select w-full" name="billing_cycle" required>
                            <option value="">Select Billing Cycle</option>
                            <option value="MONTHLY" @if($getStudent->billing_cycle == 'MONTHLY') selected="selected" @endif>Monthly</option>
                            <option value="QUARTERLY" @if($getStudent->billing_cycle == 'QUARTERLY') selected="selected" @endif>Quarterly</option>
                        </select>
                    </div>

                     <div class="mt-3">
                        <label>Registration Mode<span class="mandatory">*</span></label>
                        <select class="tail-select w-full" name="registration_mode" required>
                            <option value="">Select Registration Mode</option>
                            <option value="OFFLINE" @if($getStudent->mode == 'OFFLINE') selected="selected" @endif>Offline</option>
                            <option value="ONLINE" @if($getStudent->mode == 'ONLINE') selected="selected" @endif>Online</option>
                        </select>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Update</button>

                    <a href="{{ route('admin.studentList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection