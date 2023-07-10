@extends('layouts.admin')
@section('title','Edit workshop & batch')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit workshop & batch
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-12 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Edit workshop & batch
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedCourse') }}" method="post" id="addFauclty" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $getCourse->id }}" />

                    <input type="hidden" name="course_id" value="{{ $getCourse->course_id }}" />

                    <input type="hidden" name="course_type" value="{{ $getCourse->course_type }}" />

                    <input type="hidden" name="uuid" value="{{ $getCourse->course->uuid }}" />

                    <div class="mt-3">
                        <label>Select Batches</label>
                        <select data-placeholder="Select Batches" name="batch[]" data-search="true" class="select2 menulist w-full" required multiple>
                            <option value="">Select Batches</option>
                            @if(!is_null($workShop))
                                @foreach($workShop as $wk => $wv)
                                    @if($wv->engagement_type == 1)
                                        <option value="{{ $wv->id }}" @if(in_array($wv->id,$batchId)) selected="selected" @endif>{{ $wv->title }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Select Workshop</label>
                        <select data-placeholder="Select Workshop" name="batch[]" data-search="true" class="select2 menulist w-full" required multiple>
                            <option value="">Select Workshop</option>
                            @if(!is_null($workShop))
                                @foreach($workShop as $wk => $wv)
                                    @if($wv->engagement_type == 2)
                                        <option value="{{ $wv->id }}" @if(in_array($wv->id,$batchId)) selected="selected" @endif>{{ $wv->title }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Course Type<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="course_type" id="course_type" disabled required>
                            <option value="">Select Course Type</option>
                            <option value="1" @if($getCourse->course_type == 1) selected="selected" @endif>Update</option>
                            <option value="2" @if($getCourse->course_type == 2) selected="selected" @endif>Images</option>
                            <option value="3" @if($getCourse->course_type == 3) selected="selected" @endif>Document</option>
                        </select>
                    </div>

                    <div class="box mt-5 @if($getCourse->course_type !== 1) hide @endif update">
                        
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Update
                            </h2>
                        </div>

                        <div id="inline-form" class="p-5">
                            <div class="preview" id="updatePreview">
                                @if(!is_null($getCourse) && $getCourse->course_type == 1)
                                    <div class="grid grid-cols-12 gap-2 addUpdate">
                                        <input type="text" class="form-control col-span-4" placeholder="Update Message" aria-label="default input inline 1" name="message" value="{{ $getCourse->message }}">
                                        <input type="url" class="form-control col-span-4" placeholder="URL" aria-label="default input inline 2" name="url" value="{{ $getCourse->url }}" >
                                        <a class="btn btn-primary w-30 mr-1 mb-2 mt-4 removeRow" href="javascript:void(0);">x</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box mt-5 @if($getCourse->course_type !== 2) hide @endif image">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Images
                            </h2>
                        </div>
                        <div id="inline-form" class="p-5">
                            <div class="preview" id="imagePreview">
                                <input type="file" name="image" >
                            </div>
                            <div class="intro-y grid grid-cols-12 gap-3 sm:gap-6 mt-5">
                                @if(!is_null($getCourse) && $getCourse->course_type == 2)
                                    <div class="intro-y col-span-6 sm:col-span-4 md:col-span-3 xxl:col-span-2 image_{{ $getCourse->id }}">
                                        <div class="file box rounded-md px-5 pt-8 pb-5 px-3 sm:px-5 relative zoom-in">
                                            <a href="" class="w-3/5 file__icon file__icon--image mx-auto">
                                                <div class="file__icon--image__preview image-fit">
                                                    <img alt="course" src="{{ asset('uploads/course') }}/{{ $getCourse->course->uuid }}/images/{{ $getCourse->file_name }}">
                                                </div>
                                            </a>
                                            <div class="absolute top-0 right-0 mr-2 mt-2 dropdown ml-auto">
                                                <a href="javascript:void(0);" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md removeImage" data-id="{{ $getCourse->id }}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash w-4 h-4 mr-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="box mt-5 @if($getCourse->course_type !== 3) hide @endif document">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Document
                            </h2>
                        </div>
                        <div id="inline-form" class="p-5">
                            <div class="preview" id="documentPreview">
                                @if(!is_null($getCourse) && $getCourse->course_type == 3)
                                    <div class="grid grid-cols-12 gap-2 mb-2 addUpdate">
                                        <input type="text" class="form-control col-span-4" placeholder="Title" aria-label="default input inline 1" name="title" value="{{ $getCourse->title }}" style="height:20%;margin-top:25%">
                                        <input type="file" class="form-control col-span-4 dropify" name="document" placeholder="Input inline 2" aria-label="default input inline 2" data-default-file="{{ asset('uploads/document') }}/{{ $getCourse->course->uuid }}/{{ $getCourse->file_name }}" data-allowed-file-extensions="pdf docx rtf">
                                        <a class="btn btn-primary mr-1 mb-2 mt-4 removeRow" href="javascript:void(0);" style="margin-top:25%">x</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Update</button>

                    <a href="{{ route('admin.courseList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $('.select2').select2();
</script>
@endsection