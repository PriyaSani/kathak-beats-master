<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\LatestWork;
use App\Models\LatestWorkVideo;
use Illuminate\Http\Request;

class CmsController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        $this->middleware('checkpermission');
    }

    public function editLatestWork(){

        $getWork = LatestWork::where('id',1)->with(['video'])->first();

    	return view('admin.latest-work.edit_latest_work',compact('getWork'));
    }

    public function saveEditedLatestWork(Request $request){

    	$saveWork = LatestWork::findOrFail($request->id);
        $saveWork->first_paragraph = $request->first_paragraph;
        $saveWork->second_paragraph = $request->second_paragraph;
        $saveWork->save();

        $removeOtherWork = LatestWorkVideo::where('latest_work_id',1)->delete();
        if(!is_null($request['video'])){
            foreach($request['video'] as $vk => $vv){
                $work = new LatestWorkVideo;
                $work->latest_work_id = $request->id;
                $work->title = $vv['title'];
                $work->url = $vv['url'];
                $work->priority = $vv['priority'];
                $work->is_active = isset($vv['status']) ? 1 : 0;
                if(isset($vv['thumb'])){
                    $fileName = $this->uploadBucket($vv['thumb'],'work');
                    $work->thumb = $fileName;
                } else {
                    $work->thumb = $vv['file'];
                }
                $work->save();
            }
        }

        return redirect()->back()->with('messages', [
            [
                'type' => 'success',
                'title' => 'Work',
                'message' => 'Work successfully updated',
            ],
        ]);
    }
}
