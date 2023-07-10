@extends('layouts.admin')
@section('title','Add workshop & batch')
@section('content')
<style>
.hasImage:hover section {
  background-color: rgba(5, 5, 5, 0.4);
}
.hasImage:hover button:hover {
  background: rgba(5, 5, 5, 0.45);
}

#overlay p,
i {
  opacity: 0;
}

#overlay.draggedover {
  background-color: rgba(255, 255, 255, 0.7);
}
#overlay.draggedover p,
#overlay.draggedover i {
  opacity: 1;
}

.group:hover .group-hover\:text-blue-800 {
  color: #2b6cb0;
}
</style>
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Add workshop & batch
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-12 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Add workshop & batch
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveCourse') }}" method="post" id="addCourse" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-3">
                        <label>Select Batches</label>
                        <select data-placeholder="Select Batches" name="batch[]" data-search="true" id="batch" class="select2 menulist w-full" multiple>
                            <option value="">Select Batches</option>
                            @if(!is_null($workShop))
                                @foreach($workShop as $wk => $wv)
                                    @if($wv->engagement_type == 1)
                                        <option value="{{ $wv->id }}" @if($wv->uuid == $uuid) selected="selected" @endif>{{ $wv->title }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Select Workshop</label>
                        <select data-placeholder="Select Workshop" name="batch[]" data-search="true" id="workshop" class="select2 menulist w-full" multiple>
                            <option value="">Select Workshop</option>
                            @if(!is_null($workShop))
                                @foreach($workShop as $wk => $wv)
                                    @if($wv->engagement_type == 2)
                                        <option value="{{ $wv->id }}" @if($wv->uuid == $uuid) selected="selected" @endif>{{ $wv->title }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Course Type<span class="mandatory">*</span></label>
                        <select class="form-control menulist w-full" name="course_type" id="course_type" data-msg="Select Course Type" required>
                            <option value="">Select Course Type</option>
                            <option value="1" @if($medium == 'update') selected="selected" @endif>Update</option>
                            <option value="2" @if($medium == 'images') selected="selected" @endif>Images</option>
                            <option value="3" @if($medium == 'documents') selected="selected" @endif>Document</option>
                        </select>
                    </div>

                    <div class="box mt-5 @if($medium != 'update') hide @endif update">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Update
                            </h2>
                        </div>
                        <div id="inline-form" class="p-5">
                            <div class="preview" id="updatePreview">
                                
                            </div>
                            <a href="javascript:void(0);" class="btn btn-danger w-24 mr-1 mb-2 mt-4" id="addUpdate" data-id="0">+</a>
                        </div>
                    </div>

                    <div class="box mt-5 @if($medium != 'images') hide @endif image">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Images
                            </h2>
                        </div>
                        <div id="inline-form" class="p-5">
                            <div class="preview" id="imagePreview">
                                <input type="file" name="data[]"  multiple>
                            </div>
                        </div>
                    </div>

                    <div class="box mt-5 @if($medium != 'documents') hide @endif document">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">
                                Document
                            </h2>
                        </div>
                        <div id="inline-form" class="p-5">
                            <div class="preview" id="documentPreview">
                            </div>
                            <a href="javascript:void(0);" class="btn btn-danger w-24 mr-1 mb-2 mt-4" id="addDocument">+</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Save</button>

                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="save_and_add_new" >Save & Add New</button>

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
    $(document).on('submit','#addCourse',function(e){
        if($('#batch').val() == '' && $('#workshop').val() == ''){
            e.preventDefault();
            toastr['error']('Select atleast one batch or workshop to proceed');
        } 
    })
</script>
@endsection