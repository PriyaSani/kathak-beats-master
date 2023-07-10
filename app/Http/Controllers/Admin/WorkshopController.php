<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Jobs\ScheduleChange;
use App\Jobs\UpcomingBatch;
use App\Models\Admin;
use App\Models\Course;
use App\Models\CourseUpdate;
use App\Models\CourseWorkshop;
use App\Models\Studio;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopAttendance;
use App\Models\WorkshopAttendanceDetail;
use App\Models\WorkshopCourse;
use App\Models\WorkshopFaculty;
use App\Models\WorkshopStudents;
use App\Models\WorkshopTimetable;
use Illuminate\Http\Request;

class WorkshopController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function workshopList(Request $request){

        $filter = 0;
        $engagement_type = 0;
        $engagement_mode = 0;
        $engagement_status = 1;
        $booking_status = 0;
        $frequency = 0;
        $studio_type = 0;
        $min_student = "";
        $max_student = "";
        $min_price = "";
        $max_price = "";
        $instuctor = "";
        $startDateRange = "";
        $endDateRange = "";

        $studio = Studio::where('is_active',1)->where('is_delete',0)->get();

        $getFacultyList = Admin::where('is_active',1)->where('is_delete',0)->get();

        $query = Workshop::where('is_delete',0);

        //engagement_type
        if(isset($request->engagement_type) && $request->engagement_type != ''){
            $filter = 1;

            $engagement_type = $request->engagement_type;
            $query->where('engagement_type',$request->engagement_type);
        }

        //engagement_mode
        if(isset($request->engagement_mode) && $request->engagement_mode != ''){
            $filter = 1;

            $engagement_mode = $request->engagement_mode;
            $query->where('engagement_mode',$request->engagement_mode);
        }

        //engagement_status
        if(isset($request->engagement_status) && $request->engagement_status != ''){
            $filter = 1;
            $engagement_status = $request->engagement_status;
            $a = $request->engagement_status == 2 ? 0 : 1;
            $query->where('is_active',$a);
        } else {
            $query->where('is_active',1);
        }

        //booking
        if(isset($request->booking_status) && $request->booking_status != ''){
            $filter = 1;
            $booking_status = $request->booking_status;
            $b = $request->booking_status == 2 ? 0 : 1;
            $query->where('booking',$b);
        }

        //frequency
        if(isset($request->frequency) && $request->frequency != ''){
            $filter = 1;

            $frequency = $request->frequency;
            $query->where('frequency',$request->frequency);
        }

        //studio_type
        if(isset($request->studio_type) && $request->studio_type != ''){
            $filter = 1;

            $studio_type = $request->studio_type;
            $query->where('studio_id',$request->studio_type);
        }

        //min student
        if(isset($request->min_student) && $request->min_student != ''){
            $filter = 1;

            $min_student = $request->min_student;
            $query->where('students','>=',$request->min_student);
        }

        //max student
        if(isset($request->max_student) && $request->max_student != ''){
            $filter = 1;

            $max_student = $request->max_student;
            $query->where('students','<=',$request->max_student);
        }

        //min price
        if(isset($request->min_price) && $request->min_price != ''){
            $filter = 1;

            $min_price = $request->min_price;
            $query->where('price','>=',$request->min_price);
        }

        //max price
        if(isset($request->max_price) && $request->max_price != ''){
            $filter = 1;

            $max_price = $request->max_price;
            $query->where('price','<=',$request->max_price);
        }

        //instuctor
        if(isset($request->instuctor) && $request->instuctor != ''){
            $filter = 1;
            $instuctor = $request->instuctor;
            $query->whereHas('workshopfaculty',function($q) use ($instuctor){
                $q->where('faculty_id',$instuctor);
            });
        }

        if(isset($request->start_daterange) && $request->start_daterange != ''){
            $filter = 1;
            $startDateRange = $request->start_daterange;
            $date = explode('-',$request->start_daterange);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereDate('start_date','>=',$date1);
            $query->whereDate('start_date','<=',$date2);
        }

        if(isset($request->end_daterange) && $request->end_daterange != ''){
            $filter = 1;
            $endDateRange = $request->end_daterange;
            $date = explode('-',$request->end_daterange);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereDate('end_date','>=',$date1);
            $query->whereDate('end_date','<=',$date2);
        }

        $query->where('is_delete',0);
        $workshopList = $query->withCount(['workshopstudent'])->with(['timetable','studio','workshopfaculty' => function($q) {$q->with('faculty');}])->get();

        // echo "<pre>";
        // print_r($workshopList->toArray());
        // exit;

        return view('admin.batch.batch_list',compact('workshopList','filter','engagement_type','engagement_mode','engagement_status','booking_status','frequency','studio','studio_type','min_student','max_student','min_price','max_price','getFacultyList','instuctor', 'startDateRange', 'endDateRange'));
    }

    public function addWorkshop(){

    	$getFacultyList = Admin::where('is_active',1)->where('is_delete',0)->get();

    	$studio = Studio::where('is_active',1)->where('is_delete',0)->get();

    	return view('admin.batch.add_batch',compact('getFacultyList','studio'));
    }

    public function saveWorkshop(Request $request){

        $workshop = new Workshop;
        $workshop->uuid = $this->generateUUID();
        $workshop->engagement_type = $request->engagement_type;
        $workshop->engagement_mode = $request->engagement_mode;
        $workshop->studio_id = $request->studio;
        $workshop->title = $request->title;
        if(isset($request->poster)){
            $filename = $this->uploadBucket($request->poster,'poster');
            $workshop->poster = $filename;
        }
        $workshop->description = $request->short_description;
        $workshop->price = $request->price;
        $workshop->about = $request->about;
        $workshop->content = $request->content;
        if($request->engagement_type == 1){
            $workshop->actual_start_date = $request->actual_start_date ? $this->convertDate($request->actual_start_date) : null;
            $workshop->start_date = $request->start_date ? $this->convertDate($request->start_date) : null;
            $workshop->end_date = $request->end_date ? $this->convertDate($request->end_date) : null;
            $workshop->frequency = $request->frequency;
        } else {
            $daterange = explode('-',$request->daterange);
            $workshop->start_date = $this->convertDate(trim($daterange[0]));
            $workshop->end_date = $this->convertDate(trim($daterange[1]));
            $workshop->frequency = null;
        }
        $workshop->booking = isset($request->booking) ? 1 : 0;
        $workshop->save();

        if(!is_null($request->instuctor)){
            foreach($request->instuctor as $ik => $iv){
                $instuctor = new WorkshopFaculty;
                $instuctor->workshop_id = $workshop->id;
                $instuctor->faculty_id = $iv;
                $instuctor->save();
            }
        }   

        if($request->engagement_type == 2){
            if(!is_null($request->data)){
                foreach($request->data as $ik => $iv){
                    if(isset($iv['select_date'])){
                        $instuctor = new WorkshopTimetable;
                        $instuctor->workshop_id = $workshop->id;
                        if($request->engagement_type != 1){
                            $instuctor->date = $iv['date'] ? $this->convertDate($iv['date']) : null;
                        } else {
                            $instuctor->day_id = $iv['day'];
                        }
                        $instuctor->start_time = $iv['start_time'];
                        $instuctor->end_time = $iv['end_time'];
                        $instuctor->save();
                    }
                }
            }
        } else {
            if(!is_null($request->data)){
                foreach($request->data as $ik => $iv){
                    $instuctor = new WorkshopTimetable;
                    $instuctor->workshop_id = $workshop->id;
                    if($request->engagement_type != 1){
                        $instuctor->date = $iv['date'] ? $this->convertDate($iv['date']) : null;
                    } else {
                        $instuctor->day_id = $iv['day'];
                    }
                    $instuctor->start_time = $iv['start_time'];
                    $instuctor->end_time = $iv['end_time'];
                    $instuctor->save();
                }
            }
        }

        if($request->engagement_type == 1){

            $dateArray = $this->getDateDifference($this->convertDate($request->start_date),$this->convertDate($request->end_date),$request->data);

            if(!is_null($dateArray)){
                foreach($dateArray as $dk => $dv){
                    $workshopA = new WorkshopAttendance;
                    $workshopA->workshop_id = $workshop->id;
                    $workshopA->date = $dv['date'];
                    $workshopA->start_time = $dv['start_time'];
                    $workshopA->end_time = $dv['end_time'];
                    $workshopA->attendees = 0;
                    $workshopA->save();
                }
            }
        } else {
            if(!is_null($request->data)){
                foreach($request->data as $dk => $dv){
                    $workshopA = new WorkshopAttendance;
                    $workshopA->workshop_id = $workshop->id;
                    $workshopA->date = $this->convertDate($dv['date']);
                    $workshopA->start_time = $dv['start_time'];
                    $workshopA->end_time = $dv['end_time'];
                    $workshopA->attendees = 0;
                    $workshopA->save();
                }
            }
        }

        $userList = User::where('is_active',1)->where('is_delete',0)->select('email','contact_number')->get();

        if(!is_null($userList)){
            foreach($userList as $uk => $uv){
                if($uv->is_blocked == 0){
                    $this->dispatch((new UpcomingBatch($uv->email))->delay(5));
                    // $this->sendSmsNotification($uv->contact_number,'New batch or workshop added');
                }
            }
        }
        
        $route = $request->btn_submit == 'list' ? 'admin.workshopList' : 'admin.addWorkshop';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Work',
                'message' => 'Engagement added successfully',
            ],
        ]);

    }

    public function editWorkShop($uuid){

        $workshop = Workshop::where('uuid',$uuid)->with(['workshopfaculty','timetable'])->first();

        $getFacultyList = Admin::where('is_active',1)->where('is_delete',0)->get();

        $studio = Studio::where('is_active',1)->where('is_delete',0)->get();

        $faculty = array();

        if(!is_null($workshop->workshopfaculty)){
            foreach($workshop->workshopfaculty as $wk => $wv){
                $faculty[] = $wv->faculty_id;
            }
        }

        return view('admin.batch.edit_batch',compact('getFacultyList','studio','workshop','faculty'));
    }

    public function saveEditedWorkshop(Request $request){

        $workshop = Workshop::findOrFail($request->id);
        $workshop->engagement_type = $request->engagement_type;
        $workshop->engagement_mode = $request->engagement_mode;
        $workshop->studio_id = $request->studio;
        $workshop->title = $request->title;
        if(isset($request->poster)){
            $filename = $this->uploadBucket($request->poster,'poster');
            $workshop->poster = $filename;
        }
        if($request->engagement_type == 1){
            $workshop->actual_start_date = $request->actual_start_date ? $this->convertDate($request->actual_start_date) : null;
            $workshop->start_date = $request->start_date ? $this->convertDate($request->start_date) : null;
            $workshop->end_date = $request->end_date ? $this->convertDate($request->end_date) : null;
            $workshop->frequency = $request->frequency;
        } else {
            $daterange = explode('-',$request->daterange);
            $workshop->start_date = $this->convertDate(trim($daterange[0]));
            $workshop->end_date = $this->convertDate(trim($daterange[1]));
            $workshop->frequency = null;
        }
        $workshop->description = $request->short_description;
        $workshop->price = $request->price;
        $workshop->about = $request->about;
        $workshop->content = $request->content;
        $workshop->start_date = $request->start_date ? $this->convertDate($request->start_date) : null;
        $workshop->end_date = $request->end_date ? $this->convertDate($request->end_date) : null;
        $workshop->booking = isset($request->booking) ? 1 : 0;
        $workshop->save();

        $deleteInstuctor = WorkshopFaculty::where('workshop_id',$request->id)->delete();
        if(!is_null($request->instuctor)){
            foreach($request->instuctor as $ik => $iv){
                $instuctor = new WorkshopFaculty;
                $instuctor->workshop_id = $request->id;
                $instuctor->faculty_id = $iv;
                $instuctor->save();
            }
        }

        $removeAttendance = WorkshopAttendance::where('workshop_id',$workshop->id)->delete();

        $removeWorkshopTimeTable = WorkshopTimetable::where('workshop_id',$request->id)->delete();
         if($request->engagement_type == 2){
            if(!is_null($request->data)){
                foreach($request->data as $ik => $iv){
                    if(isset($iv['select_date'])){
                        $instuctor = new WorkshopTimetable;
                        $instuctor->workshop_id = $workshop->id;
                        if($request->engagement_type != 1){
                            $instuctor->date = $iv['date'] ? $this->convertDate($iv['date']) : null;
                        } else {
                            $instuctor->day_id = $iv['day'];
                        }
                        $instuctor->start_time = $iv['start_time'];
                        $instuctor->end_time = $iv['end_time'];
                        $instuctor->save();
                    }
                }
            }
        } else {
            if(!is_null($request->data)){
                foreach($request->data as $ik => $iv){
                    $instuctor = new WorkshopTimetable;
                    $instuctor->workshop_id = $workshop->id;
                    if($request->engagement_type != 1){
                        $instuctor->date = $iv['date'] ? $this->convertDate($iv['date']) : null;
                    } else {
                        $instuctor->day_id = $iv['day'];
                    }
                    $instuctor->start_time = $iv['start_time'];
                    $instuctor->end_time = $iv['end_time'];
                    $instuctor->save();
                }
            }
        }

        if($request->engagement_type == 1){
            $dateArray = $this->getDateDifference($this->convertDate($request->start_date),$this->convertDate($request->end_date),$request->data);

            if(!is_null($dateArray)){
                foreach($dateArray as $dk => $dv){
                    $workshop = new WorkshopAttendance;
                    $workshop->workshop_id = $request->id;
                    $workshop->date = $dv['date'];
                    $workshop->start_time = $dv['start_time'];
                    $workshop->end_time = $dv['end_time'];
                    $workshop->attendees = 0;
                    $workshop->save();
                }
            }
        } else {
            if(!is_null($request->data)){
                foreach($request->data as $dk => $dv){
                    $workshop = new WorkshopAttendance;
                    $workshop->workshop_id = $request->id;
                    $workshop->date = $this->convertDate($dv['date']);
                    $workshop->start_time = $dv['start_time'];
                    $workshop->end_time = $dv['end_time'];
                    $workshop->attendees = 0;
                    $workshop->save();
                }
            }
        }

        return redirect(route('admin.workshopList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Batch',
                'message' => 'Engagement edited successfully',
            ],
        ]);
    }

    public function deleteWorkshop($uuid){

        $deleteWorkShop = Workshop::where('uuid',$uuid)->update(['is_delete' => 1]);

        return redirect(route('admin.workshopList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Batch',
                'message' => 'Engagement successfully deleted',
            ],
        ]);
    }

    public function changeWorkshopStatus(Request $request){

        $updateStatus = Workshop::where('uuid',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }

    public function changeBookingStatus(Request $request){

        $updateStatus = Workshop::where('uuid',$request->id)->update(['booking' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }

    public function engagementSetting($uuid,Request $request){

        //default values
        $contentFilter = '';
        $registration_date = '';
        $getCurrentDate = array();

        $type = array('1' => 'Update','2' => 'Images','3' => 'Document');

        $darray = array('1' => 'Sunday','2' => 'Monday','3' => 'Tuesday','4' => 'Wednesday','5' => 'Thrusday','6' => 'Friday','7' => 'Saturday');


        //workshop details
        $details = Workshop::where('uuid',$uuid)->with(['timetable','workshopfaculty' => function($q) {$q->with('faculty'); }])->first();

        //------------------------------ student query section start -------------------------------//

        $registration_mode = '';
        $payment_frequency = '';
        $date_val = '';
        $studentFilter = 0;

        $studentQuery = WorkshopStudents::where('workshop_id',$details->id);

        
        if(isset($request->filter) && $request->filter == 'student'){

            if(isset($request->registration_mode)){
                $registration_mode = $request->registration_mode;
                $studentFilter = 1;
                $studentQuery->whereHas('users',function($q) use ($registration_mode){
                    $q->where('mode',$registration_mode);
                });
            }

            if(isset($request->payment_frequency)){
                $payment_frequency = $request->payment_frequency;
                $studentFilter = 1;
                $studentQuery->whereHas('users',function($q) use ($payment_frequency){
                    $q->where('billing_cycle',$payment_frequency);
                });
            }

            if(isset($request->daterange)){
                $filter = 1;
                $date_val = $request->daterange;
                $date = explode('-',$request->daterange);
                $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
                $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
                $studentQuery->whereHas('users',function($q) use ($date1,$date2){
                    $q->whereBetween('created_at',[$date1,$date2]);
                });
            }
        }

        $studentList = $studentQuery->with(['users'])->get();


        //------------------------------ student query section start -------------------------------//

        //------------------------------ update query section start -------------------------------//

        $updateFilter = 0;
        $status = 1;
        $update_date_val = 0;

        $courseQuery = WorkshopCourse::where('workshop_id',$details->id);

        if(isset($request->filter) && $request->filter == 'update'){

            if(isset($request->update_daterange)){
                $updateFilter = 1;
                $update_date_val = $request->update_daterange;
                $date = explode('-',$request->update_daterange);
                $date1 = $this->convertDate($date[0]);
                $date2 = $this->convertDate(trim($date[1]));
                $courseQuery->whereBetween('created_at',[$date1,$date2]);
            }

            if(isset($request->status)){
                $updateFilter = 1;
                $s = $request->status == 2 ? 0 : 1;
                $status = $request->status;
                $courseQuery->where('is_active',1);
            } 
        }

        $getCourse = $courseQuery->with(['course' => function($q) { $q->with(['course']); }])->get();
        //Attendance data

        //get attendance data 
        // $getAttData = WorkshopAttendance::where('workshop_id',$details->id)->where('status',1)->whereDate('date','<',date('Y-m-d'))->orderBy('id','desc')->get()->toArray();
        
        // Modified query
        $getAttData = WorkshopAttendance::where('workshop_id',$details->id)->whereDate('date','<',date('Y-m-d'))->orderBy('id','desc')->get()->toArray();

        //get current date data
        $getToday = WorkshopAttendance::where('workshop_id',$details->id)
                                      ->whereDate('date',date('Y-m-d'))
                                      ->get()
                                      ->toArray();
        
        //get Next batch date                                      
        $qNd = WorkshopAttendance::where('workshop_id',$details->id)->where('status',0);                                       
        
        /**
         * check if batch is schedule on today's date if yes then fetch only 
         * next schedule date otherwise fetch two next schedule date.       
         * */
        if(count($getToday) > 0){
            $qNd->whereDate('date','>',$getToday[0]['date'])->limit(1);                
        } else {
            $qNd->whereDate('date','>',date('Y-m-d'))->limit(2);                
        }

        $getCurrentDate = $qNd->get()->toArray();

        $getCurrentDate = array_reverse($getCurrentDate);

        $attData = array_merge($getCurrentDate,$getToday,$getAttData);

        // echo "<pre>";
        // print_r($attData);
        // exit;

        return view('admin.batch.batch_setting',compact('details','studentList','getCourse','type','attData','darray','registration_mode','payment_frequency','date_val','studentFilter','updateFilter','status','update_date_val'));
    }


    public function getDateDifference($date1, $date2,$days){

        $getDays = array();
        $batchDates = array();

        $darray = array('1' => 'Sunday','2' => 'Monday','3' => 'Tuesday','4' => 'Wednesday','5' => 'Thrusday','6' => 'Friday','7' => 'Saturday');

        foreach($days as $day){
            $getDays[] = trim($darray[$day['day']]);
        }

        $totalDays = round(abs(strtotime($date1) - strtotime($date2))/86400);

        for($i = 0;$i <= $totalDays; $i++) {
            $d = date('l',strtotime($date1."+".$i."days"));
            if(in_array($d,$getDays)){
                $index = array_search($d,$getDays);
                $batchDates[$i]['date'] = date('Y-m-d',strtotime($date1."+".$i."days"));
                $batchDates[$i]['start_time'] = $days[$index]['start_time'];
                $batchDates[$i]['end_time'] = $days[$index]['end_time'];
            }
        }

        return $batchDates;
    }
    

    public function getAttendanceDetail(Request $request){  

        $getAttendanceDetail = WorkshopAttendance::where('id',$request->id)->with(['workshop' => function($q) { $q->with(['studio']); }])->first();

        return view('admin.batch.modify_modal',compact('getAttendanceDetail'));
    }

    public function modifyTime(Request $request){

        $modify = WorkshopAttendance::findOrFail($request->id);
        $modify->date = $this->convertDate($request->shifted_date);
        $modify->start_time = $request->start_time;
        $modify->end_time = $request->end_time;
        $modify->is_reschedule = 1;
        $modify->save();

        $getWorkshopDetails = WorkshopAttendance::where('id',$request->id)
                                                ->with(['workshop' =>  function($q){
                                                    $q->with(['workshopstudent' => function($q) {
                                                        $q->with(['users']); 
                                                    }]);
                                                }])
                                                ->first();
        
        if(!is_null($getWorkshopDetails) && !is_null($getWorkshopDetails->workshop) && !is_null($getWorkshopDetails->workshop->workshopstudent)){
            foreach($getWorkshopDetails->workshop->workshopstudent as $wk => $wv){
                if(!is_null($wv->users)){

                    if($wv->users->is_blocked == 0){
                        $this->dispatch((new ScheduleChange($wv->users->email,$getWorkshopDetails->workshop->title,$request->shifted_date,$request->start_time))->delay(5));
                    }

                    $message = 'Dear Student, this is to inform you about the change in timing for '.$getWorkshopDetails->workshop->title.', class to be held on '.$request->shifted_date.' '.$request->start_time.', Team KathakBeats';

                    $this->sendSmsNotification($wv->users->contact_number,$message);
                }                
            }
        }

        return redirect(route('admin.engagementSetting',$request->uuid))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Batch',
                'message' => 'Batch successfully deleted',
            ],
        ]);
    }

    public function markAttendance($id){

        $getDetails = WorkshopAttendance::where('id',$id)->with(['workshop'])->first();

        $getStudent = WorkshopStudents::where('workshop_id',$getDetails->workshop_id)->with(['users'])->get();

        return view('admin.batch.attendance',compact('getStudent','getDetails'));
    }

    public function saveAttendance(Request $request){

        //update Lacture count in workshop student table
        $updateTotalLecture = WorkshopStudents::where('workshop_id',$request->workshop_id)->increment('total_lecture',1);

        //add user log in workshop attendance detail
        if(!is_null($request->user_id)){
            foreach($request->user_id as $uk => $uv){
                $detail = new WorkshopAttendanceDetail;
                $detail->workshop_attendance_id = $request->attendance_id;
                $detail->student_id = $uv;
                $detail->save();

                //update workshop student details
                $updateAttandance = WorkshopStudents::where('workshop_id',$request->workshop_id)->where('student_id',$uv)
                                                     ->increment('attanded_lecture',1);
            }
        }

        //workshop attances total user count 
        $update = WorkshopAttendance::where('id',$request->attendance_id)
                                    ->update([
                                        'attendees' => count($request->user_id),
                                        'status' => 1
                                    ]);

        return redirect(route('admin.engagementSetting',$request->uuid))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Batch',
                'message' => 'Attendance successfully marked',
            ],
        ]);                                    
    }

    //course update status
    public function updateStatus(Request $request){

        $updateStatus = CourseUpdate::where('id',$request->id)->update(['is_active' => $request->option]);

        return 'true';
    }

    public function addEngagementStudent($id){

        $getWorkshopDetails = Workshop::where('uuid',$id)->first();

        $getUserList = WorkshopStudents::where('workshop_id',$getWorkshopDetails->id)->pluck('student_id')->toArray();

        $query = User::query();

        if(!is_null($getUserList)){
            $query->whereNotIn('id',$getUserList);
        }

        $query->where('is_active',1)->where('is_delete',0);
        $getStudentList = $query->get();

        return view('admin.batch.add_student',compact('getStudentList','getWorkshopDetails'));
    }


    public function saveLinkedStudent(Request $request){

        $wDetail = Workshop::where('id',$request->workshop_id)->first();

        if(!is_null($request->student_id)){
            foreach($request->student_id as $sk => $sv){

                $userDetail = User::where('id',$sv)->first();
                
                if(!is_null($userDetail)){

                    $duration = !is_null($userDetail) && $userDetail->billing_cycle == 'MONTHLY' ? 1 : 3;
                    
                    //generate  user details                            
                    $data['user_id'] = $userDetail->id;
                    $data['workshop_id'] = $wDetail->id;
                    $data['duration'] = $duration;
                    $data['cycle'] = $userDetail->billing_cycle;
                    $data['discount'] = 0;
                    $data['medium'] = 0;
                    $data['mode'] = 2;
                    $data['payment_method'] = 2;
                    $data['payment_remarks'] = '';
                    $data['price'] = $this->countBatchPrice($wDetail->price,$duration,$userDetail->state_code);

                    try {

                        //$this->addPaymentEntry($data);

                        $student = new WorkshopStudents;
                        $student->student_id = $sv;
                        $student->workshop_id = $request->workshop_id;
                        $student->save();
                        
                    } catch (Exception $e) {
                        
                        return redirect(route('admin.engagementSetting',$request->uuid))->with('messages', [
                            [
                                'type' => 'error',
                                'title' => 'Batch',
                                'message' => 'Something went wrong!',
                            ],
                        ]);                           
                    }
                }
            }
            
            $totalStudents = count($request->student_id);

            $updateUser = Workshop::where('id',$request->workshop_id)->increment('students',$totalStudents);
        }

        return redirect(route('admin.engagementSetting',$request->uuid))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Batch',
                'message' => 'Student successfully linked',
            ],
        ]);
    }      

    public function updateDate(Request $request){

        $date = $this->convertDate($request->date);

        return date('d/m/Y',strtotime($date.'+1 year'));
    }

    public function unlinkUser(Request $request){

        $getWorkshopData = WorkshopStudents::where('id',$request->id)->first();

        $removeStudent = WorkshopStudents::where('id',$request->id)->delete();

        $updateUser = Workshop::where('id',$getWorkshopData->workshop_id)->decrement('students',1);

        return 'true';
    }

    public function editAttendance($id){

        $getDetails = WorkshopAttendance::where('id',$id)->with(['workshop','detail'])->first();

        $getStudent = WorkshopStudents::where('workshop_id',$getDetails->workshop_id)->with(['users'])->get();

        $presetUserId = array();

        if(!is_null($getDetails) && !is_null($getDetails->detail)){
            foreach($getDetails->detail as $dk => $dv){
                $presetUserId[] = $dv->student_id;
            }
        }

        return view('admin.batch.edit_student_attendance',compact('getStudent','getDetails','presetUserId','id'));
    }

    public function saveEditedAttendance(Request $request){

        $updateTotalLecture = WorkshopStudents::where('workshop_id',$request->workshop_id)->whereIn('student_id',json_decode($request->presetUserId))->decrement('attanded_lecture',1);

        $removeData = WorkshopAttendanceDetail::where('workshop_attendance_id',$request->attendance_id)->delete();

        $userId = isset($request->user_id) ? count($request->user_id) : 0;

        //add user log in workshop attendance detail
        if($userId != 0){
            foreach($request->user_id as $uk => $uv){
                $detail = new WorkshopAttendanceDetail;
                $detail->workshop_attendance_id = $request->attendance_id;
                $detail->student_id = $uv;
                $detail->save();

                //update workshop student details
                $updateAttandance = WorkshopStudents::where('workshop_id',$request->workshop_id)->where('student_id',$uv)->increment('attanded_lecture',1);
            }
        }

        //workshop attances total user count 
        $update = WorkshopAttendance::where('id',$request->attendance_id)
                                    ->update([
                                        'attendees' => $userId,
                                        'status' => 1
                                    ]);

        return redirect(route('admin.engagementSetting',$request->uuid))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Batch',
                'message' => 'Attendance successfully marked',
            ],
        ]);                                    
    }


    public function changeInvoiceCycle(Request $request){

        $updateCycle = WorkshopStudents::where('id',$request->workshop_student)->update(['invoice_cycle' => $request->status ]);

        return $updateCycle ? 'true' : 'false';
    }

    public function changeBatchStatus(Request $request){

        $updateCycle = WorkshopStudents::where('id',$request->workshop_student)->update(['batch_status' => $request->status ]);

        return $updateCycle ? 'true' : 'false';
    }

    public function changeWorkshopStudentStatus(Request $request){

        $updateStatus = WorkshopStudents::where('id',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }
}
