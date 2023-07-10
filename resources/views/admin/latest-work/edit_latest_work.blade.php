@extends('layouts.admin')
@section('title','Edit Latest Work')
@section('content')
<style type="text/css">
    .dropify-render img{left:0%!important;}
    .widthFifty{width:140px;}
</style>
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Latest Work
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-12 xxl:col-span-9">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    Edit Latest Work
                </h2>
                <span class="fl-r mandatory">* Mandatory fields</span>
            </div>
            <div class="p-5">
                <form class="custom-validation" action="{{ route('admin.saveEditedLatestWork') }}" method="post" id="addWork" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="1" name="id" />
                    <div class="mt-3">
                        <label>First Paragraph<span class="mandatory">*</span></label>
                        <textarea type="text" name="first_paragraph" class="input w-full border form-control mt-2" rows="5" maxlength="230" placeholder="First Paragraph" id="inputSMS" required>{{ $getWork->first_paragraph }}</textarea>
                        <span id='remainingC'>Remaining characters : {{ 230 - strlen($getWork->first_paragraph) }}</span>
                    </div>

                    <div class="mt-3">
                        <label>Second Paragraph<span class="mandatory">*</span></label>
                        <textarea type="text" name="second_paragraph" class="input w-full border form-control mt-2" rows="5" maxlength="210" placeholder="Second Paragraph" id="second" required>{{ $getWork->second_paragraph }}</textarea>
                        <span id='remainingSecond'>Remaining characters : {{ 210 - strlen($getWork->second_paragraph) }}</span>
                    </div>

                    @php $vk = 0; @endphp
                    <div class="mt-3" style="overflow-x: scroll;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Title</th>
                                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Thumb</th>
                                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">URL</th>
                                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Priority</th>
                                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th>
                                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                                </tr>
                            </thead>
                            <tbody class="video_row">
                            @if(!is_null($getWork->video))
                                @foreach($getWork->video as $vk => $vv)
                                    <tr class="video_{{ $vk }}">
                                        <td class="border">
                                            <input type="text" name="video[{{ $vk }}][title]" class="form-control widthFifty" value="{{ $vv->title }}" required>
                                        </td>
                                        <td class="border">
                                            <input type="file" name="video[{{ $vk }}][thumb]" id="video[{{ $vk }}][thumb]" class="dropify" data-default-file="{{ Config::get('constants.awsUrl') }}/work/{{ $vv->thumb }}" data-max-file-size="5M">
                                            <input type="hidden" name="video[{{ $vk }}][file]" value="{{ $vv->thumb}}" />
                                        </td>
                                        <td class="border">
                                            <input type="url" name="video[{{ $vk }}][url]" class="form-control widthFifty" value="{{ $vv->url }}" required>
                                        </td>
                                        <td class="border">
                                            <input type="text" name="video[{{ $vk }}][priority]" class="form-control widthFifty numeric" value="{{ $vv->priority }}" >
                                        </td>
                                        <td class="border">
                                            <input class="form-check-switch ml-auto" name="video[{{ $vk }}][status]"  type="checkbox" @if($vv->is_active == 1) checked="checked" @endif >
                                        </td>
                                         <td class="border">
                                            <span class="removeDiv btn btn-danger" style="cursor:pointer;" data-id="{{ $vk }}">X</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="javascript:void(0);" id="addVideo" class="btn btn-info w-30 mr-1 mb-2 mt-4 addVideo" data-id="{{ $vk + 1}}">Add Video</a>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-30 mr-1 mb-2 mt-4" name="btn_submit" value="list">Save</button>

                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
                    
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection
