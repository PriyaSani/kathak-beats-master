@extends('layouts.admin')
@section('title','Edit Studio')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Studio
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Edit Studio
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedStudio') }}" method="post" id="studioValidation" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" value="{{ $getStudio->id }}" name="id" /> 

                    <div class="mt-3">
                        <label>Studio Name<span class="mandatory">*</span></label>
                        <input type="text" name="name" class="input w-full border form-control mt-2" placeholder="Full Name" value="{{ $getStudio->name }}" required />
                    </div>

                    <div class="mt-3">
                        <label>Address<span class="mandatory">*</span></label>
                        <textarea type="text" name="address" class="input w-full border form-control mt-2" placeholder="Address" required>{{ $getStudio->address }}</textarea>
                    </div>

                    <div class="mt-3">
                        <label>City<span class="mandatory">*</span></label>
                        <input type="text" name="city" class="input w-full form-control border mt-2 city" placeholder="City" value="{{ $getStudio->city->name }}" autocomplete="off" required/>
                        <input type="hidden" name="city_id" value="{{ $getStudio->city_id }}" id="city_id">
                    </div>

                    <div class="mt-3">
                        <label>State<span class="mandatory">*</span></label>
                        <input type="text" name="state" class="input w-full form-control border mt-2 state" placeholder="State"  autocomplete="off" value="{{ $getStudio->state->name }}" required/>
                        <input type="hidden" name="state_id" value="{{ $getStudio->state_id }}" id="state_id">
                    </div>

                    <div class="mt-3">
                        <label>Country<span class="mandatory">*</span></label>
                        <input type="text" name="country" class="input w-full form-control border mt-2 country" placeholder="Country"  autocomplete="off" value="{{ $getStudio->country->name }}" required/>
                        <input type="hidden" name="country_id" value="{{ $getStudio->country_id }}" id="country_id">
                    </div>


                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Update</button>

                    <a href="{{ route('admin.studioList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection