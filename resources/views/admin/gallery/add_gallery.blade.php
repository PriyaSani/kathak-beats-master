@extends('layouts.admin')
@section('title','Add Gallery Image')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Add Gallery
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Add Gallery
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveImage') }}" method="post" id="addImage" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-3">
                        <label>Grid Type<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="grid_type" id="grid_type_gallery" required>
                            <option value="">Select Grid Type</option>
                            <option value="1">Full View</option>
                            <option value="2">50-50 View</option>
                        </select>
                        <span id="grid"></span>
                    </div>

                    <div class="grid-one hide">
	                    <div class="mt-3">
	                        <label>Image<span class="mandatory">*</span></label>
	                        <input type="file" name="image_one_one" id="image_one_one" class="dropifyGal form-control gridOne" data-max-file-size="5M" data-msg="Upload image" required/>
	                    </div>
	                </div>

	                <div class="grid-two hide">
	                    <div class="mt-3">
	                        <label>Image 1<span class="mandatory">*</span></label>
	                        <input type="file" name="image_two_one" id="image_two_one" class="dropifyGal form-control gridTwo" data-msg="Upload image" data-max-file-size="5M"/>
	                    </div>

	                    <div class="mt-3">
	                        <label>Image 2<span class="mandatory">*</span></label>
	                        <input type="file" name="image_two_two" id="image_two_two" class="dropifyGal form-control gridTwo" data-msg="Upload image" data-max-file-size="5M"/>
	                    </div>
	                </div>

	                <div class="mt-3 hidePriority hide">
                        <label>Priority</label>
                        <input type="tel" name="priority" class="input w-full border form-control mt-2 numeric priority" placeholder="Priority" />
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Save</button>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="save_and_add_new" >Save & Add New</button>

                    <a href="{{ route('admin.imageList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection