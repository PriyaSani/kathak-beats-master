<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Jobs\BatchEnrollment;
use App\Models\City;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Workshop;
use App\Models\EmailDelivery;
use App\Models\WorkshopStudents;
use Illuminate\Http\Request;
use PDF;

class StudentController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        $this->middleware('checkpermission');
    }

    public function studentList(Request $request){

        $filter = 0;
        $status = 0;
        $stateFilter = 0;
        $cityFilter = 0;
        $countryFilter = 0;
        $registration_mode = "";
        $payment_frequency = "";
        $workshop_id = "";
        $batch_id = "";
        $birthdate = "";

        $state = State::all();

        $city = City::all();

        $country = Country::all();

        $workshop = Workshop::where('is_active',1)->where('is_delete',0)->get();

    	$query = User::with(['city','country',]);

        if(isset($request->status) && $request->status != ''){
            $filter = 1;
            $status = $request->status;
            $s = $request->status == 2 ? 0 : 1;
            $query->where('is_active',$s);
        }

        if(isset($request->country_id) && $request->country_id != ''){
            $filter = 1;
            $countryFilter = $request->country_id;
            $query->where('country_id',$request->country_id);
        }

        if(isset($request->city_id) && $request->city_id != ''){
            $filter = 1;
            $cityFilter = $request->city_id;
            $query->where('city_id',$request->city_id);
        }

        if(isset($request->state_id) && $request->state_id != ''){
            $filter = 1;
            $stateFilter = $request->city_id;
            $query->where('state_id',$request->state_id);
        }

        if(isset($request->registration_mode) && $request->registration_mode != ''){
            $filter = 1;
            $registration_mode = $request->registration_mode;
            $query->where('mode',$request->registration_mode);
        }

        if(isset($request->payment_frequency) && $request->payment_frequency != ''){
            $filter = 1;
            $payment_frequency = $request->payment_frequency;
            $query->where('billing_cycle',$request->payment_frequency);
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

        if(isset($request->workshop_id) && $request->workshop_id != ''){
            $filter = 1;
            $workshop_id = $request->workshop_id;
            $query->whereHas('workshop',function($q) use ($workshop_id){
                $q->where('workshop_id',$workshop_id);
            });
        }

        if(isset($request->daterange)){
            $filter = 1;
            $birthdate = $request->daterange;
            $date = explode('-',$request->daterange);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereDate('dob','>=',$date1);
            $query->whereDate('dob','<=',$date2);
        }

        //$query->limit(20);
        $getStudentList = $query->where('is_delete',0)->get();

    	return view('admin.student.student_list',compact('getStudentList','state','city','country','filter','status','stateFilter','cityFilter','countryFilter','registration_mode','payment_frequency','workshop','workshop_id','batch_id','birthdate'));	
    }

    public function addStudent(){
    	return view('admin.student.add_student');	
    }

    public function saveStudent(Request $request){

        $uuid = $this->generateUUID();

        $student = new User;
        $student->uuid = $uuid;
        if(isset($request->profile)){
            $filename = $this->uploadBucket($request->profile,'student');
            $student->profile_image = $filename;
        }
        $student->name = $request->name;
        $student->email = $request->email;
        $student->contact_number = $request->mobile;
        $student->wp_number = $request->wp_number;
        $student->password = bcrypt('admin123');
        $student->dob = $request->dob ? $this->convertDate($request->dob) : null;
        $student->country_id = $request->country_id;
        $student->city_id = $request->city_id;
        $student->state_id = $request->state_id;
        $student->state_code = $request->state_id == 4008 ? 27 : 1200;
        $student->address = $request->address;
        $student->billing_cycle = $request->billing_cycle;
        $student->mode = $request->registration_mode;
        $student->country_code = $request->country_code;
        $student->country_code_whatsapp = $request->country_code_whatsapp;
        $student->save();

        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addStudent' : 'admin.studentList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Student',
                'message' => 'Student successfully added',
            ],
        ]);
    }

    public function editStudent($uuid){

        $getStudent = User::where('uuid',$uuid)->with(['city','country','state'])->first();

    	return view('admin.student.edit_student',compact('getStudent'));	
    }	

    public function saveEditedStudent(Request $request){

        $student = User::findOrFail($request->id);
        if(isset($request->profile)){
            $filename = $this->uploadBucket($request->profile,'student');
            $student->profile_image = $filename;
        }
        $student->name = $request->name;
        $student->email = $request->email;
        $student->contact_number = $request->mobile;
        $student->wp_number = $request->wp_number;
        $student->dob = $request->dob ? $this->convertDate($request->dob) : null;
        $student->country_id = $request->country_id;
        $student->city_id = $request->city_id;
        $student->state_id = $request->state_id;
        $student->state_code = $request->state_id == 4008 ? 27 : 1200;
        $student->address = $request->address;
        $student->billing_cycle = $request->billing_cycle;
        $student->mode = $request->registration_mode;
        $student->country_code = $request->country_code;
        $student->country_code_whatsapp = $request->country_code_whatsapp;
        $student->save();

        return redirect(route('admin.studentList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Student',
                'message' => 'Student successfully updated',
            ],
        ]);
    }

    public function deleteStudent($uuid){

    	$deleteStudent = User::where('uuid',$uuid)->update(['is_delete' => 1]);

    	return redirect(route('admin.studentList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Student',
                'message' => 'Student successfully deleted',
            ],
        ]);
    }

    public function changeStudentStatus(Request $request){
    	
    	$updateStatus = User::where('uuid',$request->id)->update(['is_active' => $request->option]);

        return $updateStatus ? 'true' : 'false';
    }

    public function checkEmail(Request $request){

        $query = User::where('email',$request->email)->where('is_delete',0);
        if(isset($request->id)){
            $query->where('id','!=',$request->id);
        }
        $checkEmail = $query->first();

        return !is_null($checkEmail) ? 'false' : 'true';
    }

    public function getStudentProfile($uuid,Request $request){

        $details = User::where('uuid',$uuid)->first();

        $filter = 0;
        $engagement_type = 0;
        $engagement_mode = 0;
        $startdate = '';
        $enddate = '';

        $query = WorkshopStudents::where('student_id',$details->id)->with(['workshop' => function($q) { $q->with(['studio']); }]);

         //engagement_type
        if(isset($request->engagement_type) && $request->engagement_type != ''){
            $filter = 1;
            $engagement_type = $request->engagement_type;
            $query->whereHas('workshop',function($q) use ($engagement_type){
                $q->where('engagement_type',$engagement_type);
            });
        }

        //engagement_mode
        if(isset($request->engagement_mode) && $request->engagement_mode != ''){
            $filter = 1;
            $engagement_mode = $request->engagement_mode;
            $query->whereHas('workshop',function($q) use ($engagement_mode){
                $q->where('engagement_mode',$engagement_mode);
            });
        }

        if(isset($request->start_daterange)){
            $filter = 1;
            $startdate = $request->start_daterange;
            $date = explode(' - ',$request->start_daterange);
            $date1 = trim($date[0]);
            $date2 = trim($date[1]);
            $query->whereHas('workshop',function($q) use ($date1,$date2){
                $q->whereDate('start_date','>=',$date1);
                $q->whereDate('start_date','<=',$date2);
            });
            
        }

        if(isset($request->end_daterange)){
            $filter = 1;
            $enddate = $request->end_daterange;
            $date = explode(' - ',$request->end_daterange);
            $date1 = trim($date[0]);
            $date2 = trim($date[1]);
            $query->whereHas('workshop',function($q) use ($date1,$date2){
                $q->whereDate('end_date','>=',$date1);
                $q->whereDate('end_date','<=',$date2);
            });
        }

        $getWorkshop = $query->get();

        $getInvoice = Invoice::where('user_id',$details->id)->with(['workshop'])->where('is_delete',0)->get();

        return view('admin.student.student_profile',compact('details','getWorkshop','getInvoice','engagement_type','engagement_mode','filter','startdate','enddate'));
    }

    public function addbatchAndWorkshop($uuid){

    	$getStudentDetails = User::where('uuid',$uuid)->first();

    	$getStaudentBatch = WorkshopStudents::where('student_id',$getStudentDetails->id)->pluck('workshop_id')->toArray();

    	$query = Workshop::where('is_delete',0)->where('is_active',1);
    	if(!is_null($getStaudentBatch)){
    		$query->whereNotIn('id',$getStaudentBatch);
    	}
    	$workshop = $query->get();

    	return view('admin.student.add_batch_workshop',compact('getStudentDetails','workshop'));	
    }

    public function saveLinkedWorkshop(Request $request){

        $userDetail = User::where('id',$request->student_id)->first();

    	if(!is_null($request->workshop_id)){
            foreach($request->workshop_id as $sk => $sv){

                $wDetail = Workshop::where('id',$sv)->first();

                if(!is_null($wDetail) && $wDetail->engagement_type != 1 && $wDetail->engagement_mode != 1){

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

                        $this->addPaymentEntry($data,$wDetail);

                        $student = new WorkshopStudents;
                        $student->student_id = $request->student_id;
                        $student->workshop_id = $sv;
                        $student->save();

                        $updateUser = Workshop::where('id',$sv)->increment('students',1);
                            
                    } catch (Exception $e) {
                            
                        return redirect(route('admin.getStudentProfile',$request->uuid))->with('messages', [
                            [
                                'type' => 'success',
                                'title' => 'Batch',
                                'message' => 'Something went wrong',
                            ],
                        ]);                           
                    }
                } else {

                    $student = new WorkshopStudents;
                    $student->student_id = $request->student_id;
                    $student->workshop_id = $sv;
                    $student->save();
                }
            }
        }

        return redirect(route('admin.getStudentProfile',$request->uuid))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Batch',
                'message' => 'Student successfully linked',
            ],
        ]);
    }

    public function unlinkWorkshop(Request $request){

        $getWorkshopData = WorkshopStudents::where('id',$request->id)->first();

    	$unlinkWorkshop = WorkshopStudents::where('id',$request->id)->delete();

        $updateUser = Workshop::where('id',$getWorkshopData->workshop_id)->decrement('students',1);

    	return 'true';
    }

    public function markAsPaid(Request $request){

        $getInvoiceDetail = Invoice::where('id',$request->invoice_id)
                                       ->with(['user' => function($q) { $q->with(['state']); } ,'workshop'])
                                       ->first();
        
        $getUserInfo = User::where('id',$getInvoiceDetail->user_id)->first();

        $pdfName = date('dmyhis').'.pdf';

        //generate invoice                                           
        $pdf = PDF::loadView('pdf.invoice', compact('getInvoiceDetail','getUserInfo'));

        $path = "/uploads/invoice/".$pdfName;

        \Storage::disk('s3')->put($path, $pdf->output(), 'public-read');

        $updateInvoice = Invoice::where('id',$request->invoice_id)
                                ->update([
                                    'status' => 'PAID',
                                    'file' => $pdfName,
                                    'invoice_date' => date('Y-m-d')
                                ]);
        
        $invoiceCount = Invoice::where('workshop_id',$getInvoiceDetail->workshop_id)
                                   ->where('user_id',$getInvoiceDetail->user_id)                                
                                   ->count();

        $checkForPendingInvoice = Invoice::where('workshop_id',$getInvoiceDetail->workshop_id)->where('user_id',$getInvoiceDetail->user_id)->where('status','PENDING')->first();


        if(is_null($checkForPendingInvoice)){
            $updateUserAccess  = WorkshopStudents::where('workshop_id',$getInvoiceDetail->workshop_id)->where('student_id',$getInvoiceDetail->user_id)->update(['is_active' => 1]);
        } 

        \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");
        \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");
        \Log::channel('paymentlog')->error("Function: Payment Information update using mark as paid for invoice :".$request->invoice_id);
        \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");
        \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");
        
        if($invoiceCount == 1){
            $this->dispatch((new BatchEnrollment($getInvoiceDetail->user->name,$getInvoiceDetail->workshop->title,$getInvoiceDetail->user->email))->delay(5));                    
        }                                   

        return  $updateInvoice ? 'true' : 'false';
    }

    public function blockUserList(){

        $user = User::where('is_blocked',1)->get();

        return view('admin.block-user.block_user_list',compact('user'));
    }

    public function unblockUser($id){

        $user = User::where('uuid',$id)->first();

        if(!is_null($user)){
            $updateUser = User::where('id',$user->id)->update(['is_blocked' => 0]);
            $removeEmail = EmailDelivery::where('email',$user->email)->delete();
        }

        return redirect()->back()->with('messages', [
            [
                'type' => 'success',
                'title' => 'Student',
                'message' => 'Student successfully unblocked',
            ],
        ]);
    }
}
