<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\GlobalController;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        $this->middleware('checkpermission');
    }

    public function videoList(Request $request){

        $filter = 0;
        $gridType = "";
        $status = "";


        $grid = [1 => 'Full View',2 => '60-40 Views',3 => '40-60 Views'];

        $query = Video::where('is_delete',0);

        if(isset($request->status) && $request->status != ''){
            $filter = 1;
            $status = $request->status;
            $s = $request->status == 2 ? 0 : 1;
            $query->where('is_active',$s);
        }

        if(isset($request->grid_type) && $request->grid_type != ''){
            $filter = 1;
            $gridType = $request->grid_type;
            $query->where('grid_type',$gridType);
        }

        $getVideo = $query->get();

    	return view('admin.video.video_list',compact('getVideo','grid','gridType','status','filter'));
    }

    public function addVideo(){

    	return view('admin.video.add_video');
    }

    public function saveVideo(Request $request){

        $video = new Video;
        $video->uuid = $this->generateUUID();
        $video->grid_type = $request->grid_type;

        if($request->grid_type == 1){

            $video->video_title_one = $request->title_one_one;

            if(isset($request->image_one_one)){
                $imgOne = $this->uploadBucket($request->image_one_one,'video');
                $video->video_thumbnail_one = $imgOne;
            }

            $video->video_url_one = $request->url_one_one;

        } elseif($request->grid_type == 2) {

            $video->video_title_one = $request->title_two_one;
            $video->video_title_two = $request->title_two_two;

            if(isset($request->image_two_one)){
                $imgTwo = $this->uploadBucket($request->image_two_one,'video');
                $video->video_thumbnail_one = $imgTwo;
            }
            if(isset($request->image_two_two)){
                $imgThree = $this->uploadBucket($request->image_two_two,'video');
                $video->video_thumbnail_two = $imgThree;
            }

            $video->video_url_one = $request->url_two_one;
            $video->video_url_two = $request->url_two_two;

        } else {

            $video->video_title_one = $request->title_three_one;
            $video->video_title_two = $request->title_three_two;

            if(isset($request->image_three_one)){
                $imgTwo = $this->uploadBucket($request->image_three_one,'video');
                $video->video_thumbnail_one = $imgTwo;
            }
            if(isset($request->image_three_two)){
                $imgThree = $this->uploadBucket($request->image_three_two,'video');
                $video->video_thumbnail_two = $imgThree;
            }

            $video->video_url_one = $request->url_three_one;
            $video->video_url_two = $request->url_three_two;
        }

        $video->priority = $request->priority;
        $video->save();

        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addVideo' : 'admin.videoList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Video',
                'message' => 'Video successfully added',
            ],
        ]);
    }

    public function editVideo($uuid){

        $getVideo = Video::where('uuid',$uuid)->first();

    	return view('admin.video.edit_video',compact('getVideo'));
    }

    public function saveEditedVideo(Request $request){

        $video = Video::findOrFail($request->id);
        $video->uuid = $this->generateUUID();
        $video->grid_type = $request->grid_type;

        if($request->grid_type == 1){

            $video->video_title_one = $request->title_one_one;

            if(isset($request->image_one_one)){
                $imgOne = $this->uploadBucket($request->image_one_one,'video');
                $video->video_thumbnail_one = $imgOne;
            }

            $video->video_url_one = $request->url_one_one;
            $video->video_title_two = null;
            $video->video_thumbnail_two = null;
            $video->video_url_two = null;

        } elseif($request->grid_type == 2) {

            $video->video_title_one = $request->title_two_one;
            $video->video_title_two = $request->title_two_two;

            if(isset($request->image_two_one)){
                $imgTwo = $this->uploadBucket($request->image_two_one,'video');
                $video->video_thumbnail_one = $imgTwo;
            }
            if(isset($request->image_two_two)){
                $imgThree = $this->uploadBucket($request->image_two_two,'video');
                $video->video_thumbnail_two = $imgThree;
            }

            $video->video_url_one = $request->url_two_one;
            $video->video_url_two = $request->url_two_two;

        } else {

            $video->video_title_one = $request->title_three_one;
            $video->video_title_two = $request->title_three_two;

            if(isset($request->image_two_one)){
                $imgTwo = $this->uploadBucket($request->image_two_one,'video');
                $video->video_thumbnail_one = $imgTwo;
            }
            if(isset($request->image_two_two)){
                $imgThree = $this->uploadBucket($request->image_two_two,'video');
                $video->video_thumbnail_two = $imgThree;
            }

            $video->video_url_one = $request->url_three_one;
            $video->video_url_two = $request->url_three_two;
        }

        $video->priority = $request->priority;
        $video->save();

        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addVideo' : 'admin.videoList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Video',
                'message' => 'Video successfully added',
            ],
        ]);
    }

    public function deleteVideo($uuid){

    	$deleteVideo = Video::where('uuid',$uuid)->update(['is_delete' => 1]);

    	return redirect(route('admin.videoList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Video',
                'message' => 'Video successfully deleted',
            ],
        ]);
    }

    public function changeVideoStatus(Request $request){

    	$updateStatus = Video::where('uuid',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }
}
