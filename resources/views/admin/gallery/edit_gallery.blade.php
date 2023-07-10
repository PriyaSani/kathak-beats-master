@extends('layouts.admin')
@section('title','Edit Gallery Image')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Gallery
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Edit Gallery
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedImage') }}" method="post" id="addImage" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $getImage->id }}">

                    <div class="mt-3">
                        <label>Grid Type</label>
                        <select class="form-control menulist w-full" name="grid_type" id="grid_type_gallery" required>
                            <option value="">Select Grid Type</option>
                            <option value="1" @if($getImage->grid_type == 1) selected="selected" @endif>Full View</option>
                            <option value="2" @if($getImage->grid_type == 2) selected="selected" @endif>50-50 View</option>
                        </select>
                        <span id="grid"></span>
                    </div>

                    <div class="grid-one @if($getImage->grid_type == 2) hide @endif">
	                    <div class="mt-3">
	                        <label>Image<span class="mandatory">*</span></label>
	                        <input type="file" name="image_one_one" id="image_one_one" class="dropifyGal form-control gridOne" data-max-file-size="5M" data-msg="Upload image" @if($getImage->grid_type == 1) data-default-file="{{ Config::get('constants.awsUrl') }}/gallery/{{ $getImage->image_one }}" @endif  />
	                    </div>
	                </div>

	                <div class="grid-two @if($getImage->grid_type == 1) hide @endif">
	                    <div class="mt-3">
	                        <label>Image 1<span class="mandatory">*</span></label>
	                        <input type="file" name="image_two_one" id="image_two_one" class="dropifyGal form-control gridTwo" data-msg="Upload image 1" data-max-file-size="5M" @if($getImage->grid_type == 2) data-default-file="{{ Config::get('constants.awsUrl') }}/gallery/{{ $getImage->image_one }}" @endif />
	                    </div>

	                    <div class="mt-3">
	                        <label>Image 2<span class="mandatory">*</span></label>
	                        <input type="file" name="image_two_two" id="image_two_two" class="dropifyGal form-control gridTwo" data-msg="Upload image 2" data-max-file-size="5M"  @if($getImage->grid_type == 2) data-default-file="{{ Config::get('constants.awsUrl') }}/gallery/{{ $getImage->image_two }}" @endif />
	                    </div>
	                </div>

	                <div class="mt-3 hidePriority">
                        <label>Priority</label>
                        <input type="tel" name="priority" class="input w-full border priority form-control mt-2 numeric" placeholder="Priority"  value="{{ $getImage->priority }}" />
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Update</button>

                    <a href="{{ route('admin.imageList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection