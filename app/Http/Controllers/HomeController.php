<?php

namespace App\Http\Controllers;

use App\Jobs\Reminder;
use App\Models\Gallery;
use App\Models\Invoice;
use App\Models\LatestWork;
use App\Models\StudioInquiry;
use App\Models\User;
use App\Models\Video;
use App\Models\Workshop;
use App\Models\WorkshopStudents;
use App\Models\WorkshopAttendance;
use App\Models\WorkshopAttendanceDetail;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends GlobalController
{

    public function index(){

        //gallery images
        $gallery = Gallery::where('is_delete',0)->where('is_active',1)
                        ->orderBy(DB::raw('priority IS NULL, priority'), 'asc')->get();
        
        //video listing                        
        $video = Video::where('is_delete',0)->where('is_active',1)->orderBy('priority','ASC')->get();

        //latest work
        $getWork = LatestWork::where('id',1)
                             ->with(['video' => function($q){ $q->orderBy(DB::raw('priority IS NULL, priority'), 'asc'); }])
                             ->first();

        $batch = Workshop::where('is_active', 1)->where('is_delete',0)
                        ->where('booking',1)
                        ->where('engagement_type',1)
                        ->get();

        $worskhop = Workshop::where('is_active', 1)->where('is_delete',0)
                            ->where('booking',1)
                            ->where('engagement_type',2)
                            ->with(['timetable'])
                            ->get();

        return view('front.home',compact('gallery','video','getWork','batch','worskhop'));
    }

    public function about(){
        return view('front.about');
    }

    public function video(){
        return view('front.video');
    }

    public function contactUs(){
        return view('front.contact');
    }

    public function saveContactInquiry(Request $request){

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = $_SERVER['REMOTE_ADDR'];
        
        $data = [
            'secret' => '6LdRPtsdAAAAACEpFm_3HGkB5vD0TiYwXI7d6coc',
            'response' => $request->get('recaptcha'),
            'remoteip' => $remoteip
        ];

        $options = [
            'http' => [
              'header' => "Content-type: application/x-www-form-urlencoded\r\n",
              'method' => 'POST',
              'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $resultJson = json_decode($result);

        if ($resultJson->success == true) {

            $inquiry = new StudioInquiry;
            $inquiry->uuid = $this->generateUUID();
            $inquiry->full_name = $request->full_name;
            $inquiry->email = $request->email;
            $inquiry->contact_number = $request->contact_number;
            $inquiry->whatsapp_number = $request->whatsapp_number;
            $inquiry->purpose = $request->purpose;
            $inquiry->address = $request->address;
            $inquiry->save();
            
            return redirect()->back()->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'User',
                    'message' => 'Your inquiry is successfully recieved.',
                ],
            ]);

        } else {

            return redirect()->back()->with('messages', [
                [
                    'type' => 'success',
                    'title' => 'User',
                    'message' => 'Captcha error',
                ],
            ]);
        }
    }

    public function gallery(){

        $gallery = Gallery::where('is_delete',0)->where('is_active',1)->orderBy('id','desc')->get();

        return view('front.gallery',compact('gallery'));
    }

    public function batchDetail($uuid){

        $batch = Workshop::where('uuid',$uuid)->with(['workshopfaculty' => function($q){ $q->with(['faculty']); }])->first();

        return view('front.batch_detail',compact('batch','uuid'));
    }

    public function workSpaceDetails($uuid){

        $batch = Workshop::where('uuid',$uuid)->with(['timetable','workshopfaculty' => function($q){ $q->with(['faculty']); }])->first();

        return view('front.work_space_detail',compact('batch','uuid'));   
    }

    public function completeBatch(){

        $completeBatch = Workshop::where('is_completed',0)->where('is_active',1)->where('is_delete',0)->get();

        if(!is_null($completeBatch)){
            foreach($completeBatch as $ck => $cv){
                $date1 = strtotime(date('Y-m-d'));
                $date2 = strtotime($cv->end_date);
                if($date1 > $date2){
                    $updateWorkshop = Workshop::where('id',$cv->id)->update(['is_completed' => 1]);
                } 
            }
        }

        \Log::info('Batch status successfully updated');
    }    

    public function runCron(){  

        $quaterList = array(1,4,7,10);

        $getWorkshop = Workshop::where('is_completed',0)
                               ->where('is_active',1)
                               ->where('is_delete',0)
                               ->whereIn('id',array(2,1))
                               ->with(['workshopstudent' => function($q) { $q->with(['users']); }])
                               ->get();
        
        // echo "<pre>";
        // print_r($getWorkshop->toArray());
        // exit;
        //loop with workshop        
        if(!is_null($getWorkshop)){
            foreach($getWorkshop as $wk => $wv){

              
            //if workshop has student
                if(!is_null($wv->workshopstudent)){
                    foreach($wv->workshopstudent as $sk => $sv){
                        //if user object is not null in group
                        if(!is_null($sv->users) && $sv->users->id == 270){

                            //check current month
                            $currentMonth = 4;

                            //create $data object
                            $data['user_id'] = $sv->users->id;
                            $data['workshop_id'] = $wv->id;
                            $data['discount'] = 0;
                            $data['medium'] = 0;
                            $data['mode'] = 2;
                            $data['payment_method'] = 2;
                            $data['payment_remarks'] = '';

                            
                            //get last invoice form user
                            $userGetLastInvoice = Invoice::where('workshop_id',$wv->id)->where('user_id',$sv->users->id)->orderBy('id','desc')->first();

                            //check last payment cycle of invoice
                            if(!is_null($userGetLastInvoice) && $userGetLastInvoice->payment_cycle == 'QUARTERLY'){
                                //check this month is fall into new quater or not if yes then add new quater
                                if(in_array($currentMonth,$quaterList) && $sv->invoice_cycle == 'QUARTERLY'){
                                    $data['duration'] = 3;
                                    $data['cycle'] = 'QUARTERLY';
                                    $data['price'] = $this->countBatchPrice($wv->price,3,$sv->users->state_code);
                                }

                                //check this month is fall into new quater or not if yes then start payment from this month as monthly
                                if(in_array($currentMonth,$quaterList) && $sv->invoice_cycle == 'MONTHLY'){
                                    $data['duration'] = 1;
                                    $data['cycle'] = 'MONTHLY';
                                    $data['price'] = $this->countBatchPrice($wv->price,1,$sv->users->state_code);
                                }
                            } else {

                                //monthly
                                //
                                if(in_array($currentMonth,$quaterList) && $sv->invoice_cycle == 'QUARTERLY'){
                                    $data['duration'] = 3;
                                    $data['cycle'] = 'QUARTERLY';
                                    $data['price'] = $this->countBatchPrice($wv->price,3,$sv->users->state_code);
                                } else {
                                    if(!in_array($currentMonth,$quaterList) && $userGetLastInvoice->payment_cycle == 'MONTHLY'){
                                        $data['duration'] = 1;
                                        $data['cycle'] = 'MONTHLY';
                                        $data['price'] = $this->countBatchPrice($wv->price,1,$sv->users->state_code);
                                    }                                    
                                }

                                if($sv->invoice_cycle == 'MONTHLY'){
                                    $data['duration'] = 1;
                                    $data['cycle'] = 'MONTHLY';
                                    $data['price'] = $this->countBatchPrice($wv->price,1,$sv->users->state_code);
                                }
                            }


                            if(isset($data['duration'])){
                                if($wv->engagement_type == 1 && $wv->engagement_mode == 2){
                                    $this->addPaymentEntry($data,$wv);
                                } else if($wv->engagement_type == 2 && $wv->engagement_mode == 1){
                                    $this->addPaymentEntry($data,$wv);
                                } else if($wv->engagement_type == 2 && $wv->engagement_mode == 2){
                                    $this->addPaymentEntry($data,$wv);
                                }
                            }

                            if(!is_null($wv->users) && $wv->users->contact_number != ''){
                                $message = 'Dear Student, this is a gentle reminder from KathakBeats to clear the fees due towards the month of '.date('M').', '.date('Y').' kindly do the needful at the earliest.';

                                //$this->sendSmsNotification($wv->users->contact_number,$message);
                            }
                        }
                    }
                }
                
            }
        }          
        exit;
        return 'true';
    }

    // Terms and conditions page
    public function termsAndConditions(){

        return view('front.terms_and_conditions');
    }

    // Privacy policy page
    public function privacyPolicy(){

        return view('front.privacy_policy');
    }

    // Refund policy page
    public function refundPolicy($value=''){

        return view('front.refund_policy');
    }

    public function saveBatchDetail(Request $request){
        $data['batch_id'] = $request->id;
        $request->session()->put('pre_filled_data',$data);
        return 'true';
    }

    public function workshopComplete(){

        $invoiceList = Invoice::where('status', 'PENDING')->with(['user'])->get();

        if (!is_null($invoiceList)) {
            foreach ($invoiceList as $ik => $iv) {
                $userUpdate = User::where('id', $iv->user->id)->update(['is_active' => 0]);
            }
        }

    }

    public function changeBilling(){

        $invoice = Invoice::where('id','>',47)->get();

        if(!is_null($invoice)){
            foreach($invoice as $ik => $iv){

                $igst = $iv->igst_amount; // 810
                $amount = $iv->amount - $igst; //4500

                $totalGst = 100 + 18;
                $basePrice = (100 * $amount) / $totalGst; // base price

                $igst = $amount - $basePrice; // gst
                $sgst = $igst / 2;
                $cgst = $igst / 2;
                $indian = $this->getIndianCurrency($amount);

                $update = Invoice::where('id',$iv->id)
                                 ->update([
                                    'sgst_amount' => $sgst,
                                    'cgst_amount' => $cgst,
                                    'igst_amount' => $igst,
                                    'amount' => $amount,
                                    'round_off' => $amount,
                                    'base_price' => $basePrice,
                                    'amount_words' => $indian
                                ]);
            }
        }
    }

    public function emailLoop(){

        $user = User::all();

        foreach($user as $u){
            $update = User::where('id',$u->id)->update(['email_id' => $u->email]);
        }

        echo "Done";
    }

    public function snsNotification(Request $request){

        $data = $request->all();

        \Log::info(json_encode($data));
    }
        
    public function removePendingInvoice(){

        $yesterday = date("Y-m-d", strtotime('-1 days'));

        $getInvoice = Invoice::whereDate('created_at', $yesterday)->where('status','PENDING')->get();

        if(!is_null($getInvoice)){
            foreach($getInvoice as $ik => $iv){
                $checkInvoice = Invoice::where('workshop_id',$iv->workshop_id)->where('user_id',$iv->user_id)->where('id','!=',$iv->id)->first();
                if(is_null($checkInvoice)){
                    $removeInvoice = Invoice::where('id',$iv->id)->delete();
                    $removeFromWorkshop = WorkshopStudents::where('workshop_id',$iv->workshop_id)->where('student_id',$iv->user_id)->delete();
                }
            }
        }

        echo "Removed";
    }

    public function bouncesProduction(Request $request){

        $content = $request->getContent();
        $data =  $request->all();
    }

    public function complaintsProduction(Request $request){
        
        $content = $request->getContent();
        $data =  $request->all();
    }

    public function deliveriesProduction(Request $request){
        
        $content = $request->getContent();
        $data =  $request->all();
    }

    public function getStateList(Request $request){

        $state = State::where('country_id',$request->id)->get();

        $stateJson = array();

        if(!is_null($state)){
            foreach($state as $sk => $sv){
                $stateJson[$sk]['id'] = $sv->id;
                $stateJson[$sk]['name'] = $sv->name;
            }
        }

        return $stateJson;
    }

    public function getCityList(Request $request){

        $city = City::where('state_id',$request->id)->get();

        $cityJson = array();

        if(!is_null($city)){
            foreach($city as $ck => $cv){
                $cityJson[$ck]['id'] = $cv->id;
                $cityJson[$ck]['name'] = $cv->name;
            }
        }

        return $cityJson;
    }

    public function countryCode(){

        $user = User::all();

        foreach($user as $uk){

            $findCode = Country::where('id',$uk->country_id)->first();

            if(!is_null($findCode)){
                User::where('id',$uk->id)->update(['country_code' => $findCode->country_code,'country_code_whatsapp' => $findCode->country_code]);
            }
        }

        exit;
    }

    public function solveInvoiceIssue(){

        $pendinguser = array();
        $gainuser = array();

        $getstudent = WorkshopStudents::all();

        if(!is_null($getstudent)){
            foreach($getstudent as $sk => $sv){
                $getInvoice = Invoice::where('user_id',$sv->student_id)->where('workshop_id',$sv->workshop_id)->where('status','PENDING')->first();
                if(!is_null($getInvoice)){
                    $user[] = $sv->student_id;
                    $update = WorkshopStudents::where('id',$sv->id)->update(['is_active' => 0]);
                } else {
                    $gainuser[] = $sv->student_id;
                    $update = WorkshopStudents::where('id',$sv->id)->update(['is_active' => 1]);
                }
            }
        }

        echo "<pre>";
        print_r($pendinguser);
        print_r($gainuser);
        exit;

        // $user = User::where('is_delete',0)->get();

        // $data = array();

        // if(!is_null($user)){
        //     foreach($user as $uk => $uv){
        //         if($uv->id != 33){
        //             $getInvoice = Invoice::where('user_id',$uv->id)->where('status','!=','PENDING')->select('workshop_id')->get()->toArray();

        //             $d['user_id'] = $uv->id;
        //             $d['invoice'] = $getInvoice;

        //             $data[] = $d;
                    

        //         }
        //     }
        // }

        echo "<pre>";
        print_r($data);
        exit;
    }
}

