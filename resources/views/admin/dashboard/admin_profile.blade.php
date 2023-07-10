@extends('layouts.admin')
@section('title','Update Profile')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Update Profile
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Update Profile
                </h2>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('updateProfile') }}" method="post" id="updateProfile" enctype="multipart/form-data">

                    @csrf
                    
                    <input type="hidden" name="id" value="{{ Auth::guard('admin')->user()->id }}">

                    <div class="mt-3">
                        <label>Profile Picture<span class="mandatory">*</span></label>
                        <input type="file" name="profile" class="dropify form-control" data-default-file="{{ asset('uploads/profile') }}/{{ Auth::guard('admin')->user()->profile_image }}" />
                    </div>

                    <div class="mt-3">
                        <label>Full Name<span class="mandatory">*</span></label>
                        <input type="text" name="name" class="input w-full border form-control mt-2" placeholder="Full Name" value="{{ Auth::guard('admin')->user()->name }}" required />
                    </div>

                    <div class="mt-3">
                        <label>Address<span class="mandatory">*</span></label>
                        <textarea type="text" name="address" class="input w-full border form-control mt-2" placeholder="Address" required>{{ Auth::guard('admin')->user()->address }}</textarea>
                    </div>

                    <div class="mt-3">
                        @php $city = \App\Models\City::where('id',Auth::guard('admin')->user()->city_id)->first(); @endphp
                        <label>City<span class="mandatory">*</span></label>
                        <input type="text" name="city" class="input w-full form-control border mt-2" placeholder="City" value="{{ $city->name }}" required/>
                        <input type="hidden" name="city_id" value="{{ Auth::guard('admin')->user()->city_id }}">
                    </div>
                    
                   
                    <div class="mt-3">
                        <label>State<span class="mandatory">*</span></label>
                        @php $state = \App\Models\State::where('id',Auth::guard('admin')->user()->state_id)->first(); @endphp
                        <input type="text" name="state" class="input w-full form-control border mt-2" placeholder="State" value="{{ $state->name }}" required/>
                        <input type="hidden" name="state_id" value="{{ Auth::guard('admin')->user()->state_id }}">
                    </div>

                    <div class="mt-3">
                        <label>Date Of Birth</label>
                        <input class="datepicker form-control input w-full form-control border mt-2" name="dob" data-single-mode="true" value="{{ Auth::guard('admin')->user()->dob }}">
                    </div>

                    <div class="mt-3">
                        <label>Blood Group<span class="mandatory">*</span></label>
                        <select class="form-control" name="blood_group" required>
                            <option value="">Select Blood Group</option>
                            @if(!is_null(Config::get('constants.bloodGroup')))
                                @foreach(Config::get('constants.bloodGroup') as $bk => $bv)
                                    <option value="{{ $bk }}" @if($bk == Auth::guard('admin')->user()->blood_group) selected="selected" @endif>{{ $bv }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div class="mt-3">
                        <label>Mobile Number<span class="mandatory">*</span></label>
                        <input type="tel" name="mobile" class="input w-full border form-control mt-2 numeric" placeholder="Mobile Number" value="{{ Auth::guard('admin')->user()->mobile }}" maxlength="10" minlength="10" required />
                    </div>

                    <div class="mt-3">
                        <label>Email Id<span class="mandatory">*</span></label>
                        <input type="email" name="new_password" class="input w-full form-control border mt-2" placeholder="Email Id" value="{{ Auth::guard('admin')->user()->email }}" required disabled/>
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4">Update Profile</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection