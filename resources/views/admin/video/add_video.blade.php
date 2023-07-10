    @extends('layouts.admin')
@section('title','Add Video')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Add Video
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Add Video
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveVideo') }}" method="post" id="addVideo" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-3">
                        <label>Grid Type<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="grid_type" id="grid_type" required>
                            <option value="">Select Grid Type</option>
                            <option value="1">Full View</option>
                            <option value="2">60-40 Views</option>
                            <option value="3">40-60 Views</option>
                        </select>
                        <span id="grid"></span>
                    </div>

                    <div class="grid-one hide">
                        <div class="mt-3">
                            <label>Title<span class="mandatory">*</span></label>
                            <input type="tel" name="title_one_one" id="title_one_one" class="input w-full border form-control mt-2 indata gridOne" placeholder="Title"  required  data-msg="Enter title" />
                        </div>

	                    <div class="mt-3">
	                        <label>Video Thumbnail<span class="mandatory">*</span></label>
	                        <input type="file" name="image_one_one" id="image_one_one" class="dropifyVid form-control gridOne" data-max-file-size="5M" data-msg="Upload video thumbnail" required/>
	                    </div>

                        <div class="mt-3">
                            <label>URL<span class="mandatory">*</span></label>
                            <input type="url" name="url_one_one"  id="url_one_one" class="input w-full border form-control mt-2 indata gridOne" placeholder="URL"  required data-msg="Enter URL" />
                        </div>

	                </div>

	                <div class="grid-two hide">
                        <div class="mt-3">
                            <label>Title 1<span class="mandatory">*</span></label>
                            <input type="tel" name="title_two_one" id="title_two_one" title="title_two_one" class="input w-full border indata form-control mt-2 gridtwo" placeholder="Title 1" data-msg="Enter title 1" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 1<span class="mandatory">*</span></label>
                            <input type="file" name="image_two_one" id="image_two_one" class="dropifyVid form-control gridtwo" data-max-file-size="5M" data-msg="Upload thumbnail 1">
                        </div>

                        <div class="mt-3">
                            <label>URL 1<span class="mandatory">*</span></label>
                            <input type="url" name="url_two_one" id="url_two_one" class="input w-full border form-control mt-2 indata gridtwo" placeholder="URL 1" data-msg="Enter URL 1" />
                        </div>

                        <div class="mt-3">
                            <label>Title 2<span class="mandatory">*</span></label>
                            <input type="tel" name="title_two_two" id="title_two_two" class="input w-full border form-control indata gridtwo mt-2" placeholder="Title 2" data-msg="Enter title 2" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 2<span class="mandatory">*</span></label>
                            <input type="file" name="image_two_two" id="image_two_two" class="dropifyVid form-control gridtwo" data-max-file-size="5M" data-msg="Upload thumbnail 2">
                        </div>

                        <div class="mt-3">
                            <label>URL 2<span class="mandatory">*</span></label>
                            <input type="url" name="url_two_two" id="url_two_two" class="input w-full border form-control mt-2 indata gridtwo" placeholder="URL 2" data-msg="Enter URL 2" />
                        </div>
                        
                    </div>

                    <div class="grid-three hide">
                        <div class="mt-3">
                            <label>Title 1<span class="mandatory">*</span></label>
                            <input type="tel" name="title_three_one" id="title_three_one" class="input w-full border form-control mt-2 indata gridthree" placeholder="Title 1" data-msg="Enter title 1" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 1<span class="mandatory">*</span></label>
                            <input type="file" name="image_three_one" id="image_three_one" class="dropifyVid form-control gridthree" data-max-file-size="5M" data-msg="Upload thumbnail 1">
                        </div>

                        <div class="mt-3">
                            <label>URL 1<span class="mandatory">*</span></label>
                            <input type="url" name="url_three_one" id="url_three_one" class="input w-full border form-control mt-2 indata gridthree" placeholder="URL 1" data-msg="Enter URL 1" />
                        </div>

                        <div class="mt-3">
                            <label>Title 2<span class="mandatory">*</span></label>
                            <input type="tel" name="title_three_two" id="title_three_two" class="input w-full border form-control mt-2 indata gridthree" placeholder="Title 2" data-msg="Enter title 2" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 2<span class="mandatory">*</span></label>
                            <input type="file" name="image_three_two" id="image_three_two" class="dropifyVid form-control gridthree" data-max-file-size="5M" data-msg="Upload thumbnail 2">
                        </div>

                        <div class="mt-3">
                            <label>URL 2<span class="mandatory">*</span></label>
                            <input type="url" name="url_three_two" id="url_three_two" class="input w-full border form-control mt-2 indata gridthree" placeholder="URL 2" data-msg="Enter URL 2" />
                        </div>
                        
                    </div>

	                <div class="mt-3 priority hide">
                        <label>Priority</label>
                        <input type="tel" name="priority" class="input w-full border form-control mt-2 indata numeric" placeholder="Priority" />
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Save</button>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="save_and_add_new" >Save & Add New</button>

                    <a href="{{ route('admin.videoList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection