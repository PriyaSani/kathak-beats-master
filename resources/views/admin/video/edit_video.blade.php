@extends('layouts.admin')
@section('title','Edit Video')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Video
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Edit Video
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedVideo') }}" method="post" id="addVideo" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $getVideo->id }}" >

                    <div class="mt-3">
                        <label>Grid Type</label>
                        <select class="form-control menulist w-full" name="grid_type" id="grid_type">
                            <option value="">Select Grid Type</option>
                            <option value="1" @if($getVideo->grid_type == 1) selected="selected" @endif>Full View</option>
                            <option value="2" @if($getVideo->grid_type == 2) selected="selected" @endif>60-40 Views</option>
                            <option value="3" @if($getVideo->grid_type == 3) selected="selected" @endif>40-60 Views</option>
                        </select>
                        <span id="grid"></span>
                    </div>

                    <div class="grid-one @if($getVideo->grid_type != 1) hide @endif">
                        <div class="mt-3">
                            <label>Title<span class="mandatory">*</span></label>
                            <input type="tel" name="title_one_one" id="title_one_one" class="input w-full border indata form-control mt-2 gridOne" placeholder="Title" value="{{ $getVideo->video_title_one }}" required data-msg="Enter title" />
                        </div>

	                    <div class="mt-3">
	                        <label>Video Thumbnail<span class="mandatory">*</span></label>
	                        <input type="file" name="image_one_one" id="image_one_one" class="dropifyVid form-control gridOne" data-max-file-size="5M" data-msg="Upload video thumbnail"  @if($getVideo->grid_type == 1) data-default-file="{{ Config::get('constants.awsUrl') }}/video/{{ $getVideo->video_thumbnail_one }}" @endif />
	                    </div>

                        <div class="mt-3">
                            <label>URL<span class="mandatory">*</span></label>
                            <input type="url" name="url_one_one" id="url_one_one" class="input w-full border indata form-control mt-2 gridOne" placeholder="URL"  value="{{ $getVideo->video_url_one }}" required data-msg="Enter URL" />
                        </div>

	                </div>

	                <div class="grid-two @if($getVideo->grid_type != 2) hide @endif">
                        <div class="mt-3">
                            <label>Title 1<span class="mandatory">*</span></label>
                            <input type="tel" name="title_two_one" id="title_two_one" class="input w-full border indata form-control mt-2 gridtwo" placeholder="Title 1" value="{{ $getVideo->video_title_one }}" data-msg="Enter title 1" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 1<span class="mandatory">*</span></label>
                            <input type="file" name="image_two_one" id="image_two_one" class="dropifyVid form-control gridtwo" data-max-file-size="5M" data-msg="Upload thumbnail 1" @if($getVideo->grid_type == 2) data-default-file="{{ Config::get('constants.awsUrl') }}/video/{{ $getVideo->video_thumbnail_one }}" @endif>
                        </div>

                        <div class="mt-3">
                            <label>URL 1<span class="mandatory">*</span></label>
                            <input type="url" name="url_two_one" id="url_two_one" class="input w-full border indata form-control mt-2 gridtwo" placeholder="URL 1" value="{{ $getVideo->video_url_one }}" data-msg="Enter URL 1" />
                        </div>

                        <div class="mt-3">
                            <label>Title 2<span class="mandatory">*</span></label>
                            <input type="tel" name="title_two_two" id="title_two_two" class="input w-full border indata form-control gridtwo mt-2" placeholder="Title 2" value="{{ $getVideo->video_title_two }}" data-msg="Enter title 2" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 2<span class="mandatory">*</span></label>
                            <input type="file" name="image_two_two" id="image_two_two" class="dropifyVid form-control gridtwo" data-max-file-size="5M" data-msg="Upload thumbnail 2" @if($getVideo->grid_type == 2) data-default-file="{{ Config::get('constants.awsUrl') }}/video/{{ $getVideo->video_thumbnail_two }}" @endif >
                        </div>

                        <div class="mt-3">
                            <label>URL 2<span class="mandatory">*</span></label>
                            <input type="url" name="url_two_two" id="url_two_two" class="input w-full border indata form-control mt-2 gridtwo" placeholder="URL 2" value="{{ $getVideo->video_url_two }}" data-msg="Enter URL 2" />
                        </div>
                        
                    </div>

                    <div class="grid-three @if($getVideo->grid_type != 3) hide @endif">
                        <div class="mt-3">
                            <label>Title 1<span class="mandatory">*</span></label>
                            <input type="tel" name="title_three_one" id="title_three_one" class="input w-full border indata form-control mt-2 gridthree" placeholder="Title 1" value="{{ $getVideo->video_title_one }}" data-msg="Enter title 1" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 1<span class="mandatory">*</span></label>
                            <input type="file" name="image_three_one" id="image_three_one" class="dropifyVid form-control gridthree" data-max-file-size="5M" data-msg="Upload thumbnail 1" @if($getVideo->grid_type == 3) data-default-file="{{ Config::get('constants.awsUrl') }}/video/{{ $getVideo->video_thumbnail_one }}" @endif>
                        </div>

                        <div class="mt-3">
                            <label>URL 1<span class="mandatory">*</span></label>
                            <input type="url" name="url_three_one" id="url_three_one" class="input w-full border indata form-control mt-2 gridthree" placeholder="URL 1" value="{{ $getVideo->video_url_one }}" data-msg="Enter URL 1" />
                        </div>

                        <div class="mt-3">
                            <label>Title 2<span class="mandatory">*</span></label>
                            <input type="tel" name="title_three_two" id="title_three_two" class="input w-full border indata form-control mt-2 gridthree" placeholder="Title 2" value="{{ $getVideo->video_title_two }}" data-msg="Enter title 2" />
                        </div>

                        <div class="mt-3">
                            <label>Video Thumbnail 2<span class="mandatory">*</span></label>
                            <input type="file" name="image_three_two" id="image_three_two" class="dropifyVid form-control gridthree" data-max-file-size="5M" data-msg="Upload thumbnail 2" @if($getVideo->grid_type == 3) data-default-file="{{ Config::get('constants.awsUrl') }}/video/{{ $getVideo->video_thumbnail_two }}" @endif>
                        </div>

                        <div class="mt-3">
                            <label>URL 2<span class="mandatory">*</span></label>
                            <input type="url" name="url_three_two" id="url_three_two" class="input w-full border indata form-control mt-2 gridthree" placeholder="URL 2" value="{{ $getVideo->video_url_two }}" data-msg="Enter URL 2" />
                        </div>
                        
                    </div>

	                <div class="mt-3 priority hide">
                        <label>Priority</label>
                        <input type="tel" name="priority" class="input w-full border form-control indata mt-2 numeric" placeholder="Priority" value="{{ $getVideo->priority }}" />
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Update</button>
                   
                    <a href="{{ route('admin.videoList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection