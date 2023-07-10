<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\GlobalController;
use App\Jobs\CourseUpdateNotification;
use App\Models\Course;
use App\Models\CourseUpdate;
use App\Models\CourseWorkshop;
use App\Models\Workshop;
use App\Models\WorkshopCourse;
use App\Models\WorkshopStudents;
use Illuminate\Http\Request;

class CourseController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        //$this->middleware('checkpermission');
    }

    //course list
    public function courseList(){

        $type = array('1' => 'Update','2' => 'Images','3' => 'Document');

    	$getCourse = CourseUpdate::orderBy('id','desc')->with(['course','workshop'])->where('is_delete',0)->get();

    	return view('admin.course.course_list',compact('getCourse','type'));
    }

    //add course
    public function addCourse(Request $request){

        $uuid = "";
        $medium = "";

        if(isset($request->id)){
            $uuid = $request->id;
            $medium = $request->medium;            
        }

    	$workShop = Workshop::where('is_active',1)->where('is_delete',0)->get();

    	return view('admin.course.add_course',compact('workShop','uuid','medium'));
    }

    //save  course
    public function saveCourse(Request $request){

        //generate uuid
        $uuid = $this->generateUUID();

        //save group course id
    	$course = new Course;
        $course->uuid = $uuid;
        $course->save();

        //save workshop batch
        if(!is_null($request->batch)){
            foreach($request->batch as $bk => $bv){
                $batch = new CourseWorkshop;
                $batch->course_id = $course->id;
                $batch->workshop_id = $bv;
                $batch->save();
            }
        }

        //save course details
        if(!is_null($request->data)){
            foreach($request->data as $dk => $dv){
                $material = new CourseUpdate;
                $material->course_id = $course->id;
                $material->course_type = $request->course_type;
                //if update
                if($request->course_type == 1){
                    $material->message = $dv['message'];
                    $material->url = $dv['url'];
                }

                //if images
                if($request->course_type == 2){
                    if(isset($dv)){
                        $fileName = $this->uploadBucket($dv,'course/'.$uuid.'/images');
                        $material->file_name = $fileName;
                    }
                }

                //if document
                if($request->course_type == 3){
                    if(isset($dv['title'])){
                        $material->title = $dv['title'];
                        if(isset($dv['document'])){
                            $fileName = $this->uploadBucket($dv['document'],'course/'.$uuid.'/document');
                            $material->file_name = $fileName;
                        }
                    }
                }

                $material->save();

                if(!is_null($request->batch)){
                    foreach($request->batch as $bk => $bv){
                        $batch = new WorkshopCourse;
                        $batch->material_id = $material->id;
                        $batch->workshop_id = $bv;
                        $batch->save();
                    }
                }
            }
        }

        if(!is_null($request->batch)){

            $getNotification = WorkshopStudents::where('workshop_id',$request->batch)->with(['users'])->get();

            if(!is_null($getNotification)){
                foreach($getNotification as $nk => $nv){
                    if(!is_null($nv->users)){

                        if($nv->users->is_blocked == 0){
                            $this->dispatch((new CourseUpdateNotification($nv->users->email))->delay(5));        
                        }

                        $this->sendSmsNotification($nv->users->contact_number,'Hi there, KathakBeats website is updated with new content. Check it out at www.kathakbeats.in');
                    }
                }
            }
        }


        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addCourse' : 'admin.courseList';
        
        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Course',
                'message' => 'Course content successfully added',
            ],
        ]);
    }

    //edit course
    public function editCourse($id){

        $batchId = array();
        //workshop 
        $workShop = Workshop::where('is_active',1)->where('is_delete',0)->get();

    	$getCourse = CourseUpdate::where('id',base64_decode($id))->with(['course','workshop'])->first();

        $batchId = WorkshopCourse::where('material_id',base64_decode($id))->pluck('workshop_id')->toArray();

    	return view('admin.course.edit_course',compact('getCourse','workShop','batchId'));
    }

    public function saveEditedCourse(Request $request){

        $remove = CourseWorkshop::where('course_id',$request->course_id)->delete();
        $removeWorkshopCourse = WorkshopCourse::where('material_id',$request->id)->whereIn('workshop_id',$request->batch)->delete();
        //save workshop batch
        if(!is_null($request->batch)){
            foreach($request->batch as $bk => $bv){
                $batch = new CourseWorkshop;
                $batch->course_id = $request->course_id;
                $batch->workshop_id = $bv;
                $batch->save();

                $wcourse = new WorkshopCourse;
                $wcourse->material_id = $request->id;
                $wcourse->workshop_id = $bv;
                $wcourse->save();
            }
        }

        $updateCourse = CourseUpdate::findOrFail($request->id);
        if($request->course_type == 1){
            $updateCourse->message = $request->message;
            $updateCourse->url = $request->url;
        }

        if($request->course_type == 2){
            if(isset($request->image)){
                $fileName = $this->uploadBucket($request->image,'course/'.$request->uuid.'/images');
                $updateCourse->file_name = $fileName;
            }
        }
                
        if($request->course_type == 3){
            $updateCourse->title = $request->title;
            if(isset($request->document)){
                $fileName = $this->uploadBucket($request->document,'course/'.$request->uuid.'/document');
                $updateCourse->file_name = $fileName;
            }
        }

        $updateCourse->save();

        return redirect(route('admin.courseList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Course',
                'message' => 'Course successfully updated',
            ],
        ]);
    }

    public function deleteCourse($uuid){

    	$deleteCourse = CourseUpdate::where('id',base64_decode($uuid))->update(['is_delete' => 1]);

    	return redirect(route('admin.courseList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Course',
                'message' => 'Course successfully deleted',
            ],
        ]);
    }

    public function changeCourseStatus(Request $request){

    	$updateCourse = Course::where('uuid',$request->id)->update(['is_active' => $request->option]);

        return $updateCourse ? 'true' : 'false';
    }

    public function removeImageUpdate(Request $request){

        $check = WorkshopCourse::where('material_id',$request->content)->count();

        if($check == 1){
            $delete = CourseUpdate::where('id',$request->content)->delete();
        }

        $deleteUpdate = WorkshopCourse::where('id',$request->id)->delete();

        return 'true';
    }


    public function changeUpdateStatus(Request $request){

        $deleteUpdate = WorkshopCourse::where('id',$request->id)->update(['is_active' => $request->option]);

        return 'true';
    }

}

