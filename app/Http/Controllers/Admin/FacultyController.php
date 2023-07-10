<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Jobs\FacultyWelcomeEmail;
use App\Models\Admin;
use App\Models\AdminModule;
use App\Models\DashboardElement;
use App\Models\Module;
use App\Models\Studio;
use App\Models\Workshop;
use App\Models\WorkshopFaculty;
use Illuminate\Http\Request;

class FacultyController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        $this->middleware('checkpermission');
    }

    public function facultyList(Request $request){

        $filter = 0;
        $workshop_id = "";
        $batch_id = "";
        $status = "";

        $workshop = Workshop::where('is_active',1)->where('is_delete',0)->get();

        $query = Admin::where('is_delete',0);

        if(isset($request->status) && $request->status != ''){
            $filter = 1;
            $status = $request->status;
            $s = $request->status == 2 ? 0 : 1;
            $query->where('is_active',$s);
        }

        if(isset($request->batch_id) && $request->batch_id != ''){
            $filter = 1;
            $batch_id = $request->batch_id;
            $query->whereHas('workshop',function($q) use ($batch_id){
                $q->where('workshop_id',$batch_id);
            });
        }

        if(isset($request->workshop_id) && $request->workshop_id != ''){
            $filter = 1;
            $workshop_id = $request->workshop_id;
            $query->whereHas('workshop',function($q) use ($workshop_id){
                $q->where('workshop_id',$workshop_id);
            });
        }

        $getFacultyList = $query->get();

    	return view('admin.faculty.faculty_list',compact('getFacultyList','filter','workshop_id','batch_id','status','workshop'));	
    }

    public function addFaculty(){

        $modules = Module::all();

    	return view('admin.faculty.add_faculty',compact('modules'));	
    }

    public function saveFaculty(Request $request){

        $faculty = new Admin;
        $faculty->uuid = $this->generateUUID();
        $faculty->name = $request->name;
        $faculty->email = $request->email;
        $faculty->password = bcrypt($request->new_password);
        if(isset($request->profile)){
            $filename = $this->uploadBucket($request->profile,'profile');
            $faculty->profile_image = $filename;
        }
        $faculty->address = $request->address;
        $faculty->city_id = $this->checkCity($request->city);
        $faculty->state_id = $this->checkState($request->state);
        $faculty->dob = $request->dob ? $this->convertDate($request->dob) : null;
        $faculty->blood_group = $request->blood_group;
        $faculty->mobile = $request->mobile;
        $faculty->save();

        if(!is_null($request->module)){
            foreach($request->module as $mk => $mv){
                $module = new AdminModule;
                $module->admin_id = $faculty->id;
                $module->module_id = $mv;
                $module->save();
            }
        }

        if(!is_null($request->dashboard)){
            foreach($request->dashboard as $dk => $dv){
                $dashboard = new DashboardElement;
                $dashboard->admin_id = $faculty->id;
                $dashboard->element_id = $dv;
                $dashboard->save();
            }
        }

        $this->dispatch((new FacultyWelcomeEmail($request->email,$request->new_password))->delay(5));

        $this->sendSmsNotification($request->mobile,'Dear Faculty, Warm Welcome on completing your onboarding process in KathakBeats.');

        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addFaculty' : 'admin.facultyList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Faculty',
                'message' => 'Faculty successfully added',
            ],
        ]);
    }

    public function editFaculty($uuid){

        $modules = Module::all();

        $getFaculty = Admin::where('uuid',$uuid)->with(['city','state','dashboard','module'])->first();

        $module = array();
        $dashboard = array();

        if(!is_null($getFaculty)){
            foreach($getFaculty->dashboard as $dk => $dv){
                $dashboard[] = $dv->element_id;
            }
        }

        if(!is_null($getFaculty)){
            foreach($getFaculty->module as $mk => $mv){
                $module[] = $mv->module_id;
            }
        }

    	return view('admin.faculty.edit_faculty',compact('getFaculty','modules','module','dashboard'));
    }	

    public function saveEditedFaculty(Request $request){

        $faculty = Admin::findOrFail($request->id);
        $faculty->name = $request->name;
        $faculty->email = $request->email;
        if($request->new_password != ''){
            $faculty->password = bcrypt($request->new_password);
        }
        if(isset($request->profile)){
            $filename = $this->uploadBucket($request->profile,'profile');
            $faculty->profile_image = $filename;
        }
        $faculty->address = $request->address;
        $faculty->city_id = $this->checkCity($request->city);
        $faculty->state_id = $this->checkState($request->state);
        $faculty->dob = $request->dob ? $this->convertDate($request->dob) : null;
        $faculty->blood_group = $request->blood_group;
        $faculty->mobile = $request->mobile;
        $faculty->save();

        $removeModule = AdminModule::where('admin_id',$request->id)->delete();
        $removeDashboardElement = DashboardElement::where('admin_id',$request->id)->delete();

        if(!is_null($request->module)){
            foreach($request->module as $mk => $mv){
                $module = new AdminModule;
                $module->admin_id = $request->id;
                $module->module_id = $mv;
                $module->save();
            }
        }

        if(!is_null($request->dashboard)){
            foreach($request->dashboard as $dk => $dv){
                $dashboard = new DashboardElement;
                $dashboard->admin_id = $request->id;
                $dashboard->element_id = $dv;
                $dashboard->save();
            }
        }

        return redirect(route('admin.facultyList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Faculty',
                'message' => 'Faculty successfully updated',
            ],
        ]);

    }

    public function deleteFaculty($uuid){

        $deleteFaculty = Admin::where('uuid',$uuid)->update(['is_delete' => 1]);

    	return redirect(route('admin.facultyList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Faculty',
                'message' => 'Faculty successfully deleted',
            ],
        ]);
    }

    public function changeFacultyStatus(Request $request){

        $updateStatus = Admin::where('uuid',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }

    public function checkEmail(Request $request){

        $query = Admin::where('email',$request->email)->where('is_delete',0);
        if(isset($request->id)){
            $query->where('id','!=',$request->id);
        }
        $checkEmail = $query->first();

        return !is_null($checkEmail) ? 'false' : 'true';
    }

    public function checkMobile(Request $request){

        $query = Admin::where('mobile',$request->mobile)->where('is_delete',0);
        if(isset($request->id)){
            $query->where('id','!=',$request->id);
        }
        $checkMobile = $query->first();

        return !is_null($checkMobile) ? 'false' : 'true';
    }

    public function facultyProfile($uuid,Request $request){

       
        $filter = 0;
        $engagement_type = "";
        $engagement_mode = "";
        $studio_type = "";
        $startDate = "";
        $endDate = "";

        $details = Admin::where('uuid',$uuid)->first();

        $studio = Studio::where('is_active',1)->where('is_delete',0)->get();

        $workshopId = WorkshopFaculty::where('faculty_id',$details->id)->pluck('workshop_id')->toArray();

        $getWorkshopCount = WorkshopFaculty::where('faculty_id',$details->id)
                                            ->whereHas('workshop',function($q) { 
                                                $q->where('engagement_type',2);
                                                $q->where('is_delete',0);
                                            })
                                            ->count();
        
        $getBatchCount = WorkshopFaculty::where('faculty_id',$details->id)
                                            ->whereHas('workshop',function($q) { 
                                                $q->where('engagement_type',1);
                                                $q->where('is_delete',0);
                                            })
                                            ->count();                                            
        

        $query = Workshop::whereIn('id',$workshopId);

        if(isset($request->engagement_type)){
            $filter = 1;
            $engagement_type = $request->engagement_type;
            $query->where('engagement_type',$request->engagement_type);
        }

        if(isset($request->engagement_mode)){
            $filter = 1;
            $engagement_mode = $request->engagement_mode;
            $query->where('engagement_mode',$request->engagement_mode);
        }

        if(isset($request->start_date)){
            $filter = 1;
            $startDate = $request->start_date;
            $date = explode('-',$request->start_date);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereDate('start_date','>=',$date1);
            $query->whereDate('start_date','<=',$date2);
        }

        if(isset($request->end_date)){
            $filter = 1;
            $endDate = $request->end_date;
            $date = explode('-',$request->end_date);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereDate('end_date','>=',$date1);
            $query->whereDate('end_date','<=',$date2);
        }

        if(isset($request->studio_type)){
            $filter = 1;
            $studio_type = $request->studio_type;
            $query->where('studio_id',$request->studio_type); 
        }

        $query->where('is_delete',0);
        $workshop = $query->with(['studio'])->get();

        return view('admin.faculty.profile',compact('details','workshop','studio','engagement_type','engagement_mode','studio_type','getWorkshopCount','getBatchCount', 'startDate', 'endDate'));
    }

    public function unlinkFaculty(Request $request){

        $getFacultyTotal = WorkshopFaculty::where('workshop_id',$request->workshop_id)->count();

        $data['status'] = 200;

        if($getFacultyTotal > 1){
            $removeFaculty  = WorkshopFaculty::where('workshop_id',$request->workshop_id)
                                             ->where('faculty_id',$request->id)->delete();
            $data['removed'] = true;
        } else {
            $data['removed'] = false;
        }
    
        return $data;        
    }

    public function getBatchList($uuid){

        $getFaculty = Admin::where('uuid',$uuid)->first();

        $facultyId = $getFaculty->id;

        $workshop = WorkshopFaculty::where('faculty_id',$facultyId)->pluck('workshop_id')->toArray();

        $workshopList = Workshop::whereNotIn('id',$workshop)->where('is_delete',0)->get();

        return view('admin.faculty.link_faculty',compact('workshopList','facultyId','uuid'));

    }

    public function linkFaculty(Request $request){

        if(!is_null($request->workshop_id)){
            foreach($request->workshop_id as $ik => $iv){
                $instuctor = new WorkshopFaculty;
                $instuctor->workshop_id = $iv;
                $instuctor->faculty_id = $request->faculty_id;
                $instuctor->save();
            }
        }

        return redirect(route('admin.facultyProfile',$request->uuid))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Faculty',
                'message' => 'Faculty linked with workshop',
            ],
        ]);
    }
}
