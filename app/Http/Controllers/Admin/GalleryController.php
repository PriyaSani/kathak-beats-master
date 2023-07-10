<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        $this->middleware('checkpermission');
    }

    public function imageList(Request $request){

        $filter = 0;
        $grid = "";
        $status = "";

        $query = Gallery::where('is_delete',0);

        if(isset($request->status) && $request->status != ''){
            $filter = 1;
            $status = $request->status;
            $s = $request->status == 2 ? 0 : 1;
            $query->where('is_active',$s);
        }

        if(isset($request->grid) && $request->grid != ''){
            $filter = 1;
            $grid = $request->grid;
            $query->where('grid_type',$grid);
        }
        

        $galleryList = $query->get();

    	return view('admin.gallery.gallery_list',compact('galleryList','grid','status','filter'));
    }

    public function addImage(){

    	return view('admin.gallery.add_gallery');
    }

    public function saveImage(Request $request){

        $image = new Gallery;
        $image->uuid = $this->generateUUID();
        $image->grid_type = $request->grid_type;
        if($request->grid_type == 1){
            if(isset($request->image_one_one)){
                $imgOne = $this->uploadBucket($request->image_one_one,'gallery');
                $image->image_one = $imgOne;
            }
        } else {
            if(isset($request->image_two_one)){
                $imgTwo = $this->uploadBucket($request->image_two_one,'gallery');
                $image->image_one = $imgTwo;
            }
            if(isset($request->image_two_two)){
                $imgThree = $this->uploadBucket($request->image_two_two,'gallery');
                $image->image_two = $imgThree;
            }
        }
        $image->priority = $request->priority;
        $image->save();

        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addImage' : 'admin.imageList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Gallery',
                'message' => 'Gallery image successfully added',
            ],
        ]);

    }

    public function editImage($uuid){

        $getImage = Gallery::where('uuid',$uuid)->first();

    	return view('admin.gallery.edit_gallery',compact('getImage'));
    }

    public function saveEditedImage(Request $request){

        $image = Gallery::findOrFail($request->id);
        $image->grid_type = $request->grid_type;
        if($request->grid_type == 1){
            if(isset($request->image_one_one)){
                $imgOne = $this->uploadBucket($request->image_one_one,'gallery');
                $image->image_one = $imgOne;
            }
            $image->image_two = null;
        } else {
            if(isset($request->image_two_one)){
                $imgTwo = $this->uploadBucket($request->image_two_one,'gallery');
                $image->image_one = $imgTwo;
            }
            if(isset($request->image_two_two)){
                $imgThree = $this->uploadBucket($request->image_two_two,'gallery');
                $image->image_two = $imgThree;
            }
        }
        $image->priority = $request->priority;
        $image->save();

        return redirect(route('admin.imageList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Gallery',
                'message' => 'Gallery image successfully updated',
            ],
        ]);
    }

    public function deleteImage($uuid){

    	$deleteGallery = Gallery::where('uuid',$uuid)->update(['is_delete' => 1]);

    	return redirect(route('admin.imageList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Gallery',
                'message' => 'Gallery image successfully deleted',
            ],
        ]);
    }

    public function changeImageStatus(Request $request){

    	$updateStatus = Gallery::where('uuid',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }

}
