<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GlobalController;
use App\Jobs\SendLoginOtp;
use App\Jobs\SendWelcomeMail;
use App\Models\City;
use App\Models\Country;
use App\Models\ExchangeData;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\State;
use App\Models\StateCode;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopCourse;
use App\Models\WorkshopNote;
use App\Models\WorkshopStudents;
use Auth;
use Illuminate\Http\Request;
use Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

class UserController extends GlobalController
{

    private $_api_context;
    
    public function __construct()
    {
        //live 
        //AT2J7AoDBqCfcthxWnUXRTBEY2_n2CzDtY5RIT90yDa_1d-plteQrKMomUeIYxVAC3T3cWMOrSH28eC0
        //EJIfkSSvv3hIhFtOiGmeExmL2ZSKNYMc72JPlngydFqegJ_qxeg3zzoQAuOAcSMw7qz-tlJh9ICvJmpq
        
        //local
        // AaQs5MVFjfmTTE3aoW-MHpcW6etoSyZ9qoQ1VT80wmfZmUFSQ6IdcSXIRyc4zHrrmBkFp4-27T4aH1CT
        // EPlKQMoVdWbiz-q4ic8yDYX_DOL-moCKdmDL9HdH9M6sB44QSxDO9NL4KAEucrUF2FqdYZtizuYTg__Z
        $paypal_configuration = [ 
            'client_id' => 'AT2J7AoDBqCfcthxWnUXRTBEY2_n2CzDtY5RIT90yDa_1d-plteQrKMomUeIYxVAC3T3cWMOrSH28eC0',
            'secret' => 'EJIfkSSvv3hIhFtOiGmeExmL2ZSKNYMc72JPlngydFqegJ_qxeg3zzoQAuOAcSMw7qz-tlJh9ICvJmpq',
            'settings' => array(
                'mode' => 'live',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'ERROR'
            ),
        ];
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function checkLoginEmail(Request $request){
        $getEmail = User::where('email',$request->email)->where('is_active',1)->where('is_delete',0)->first();
        return !is_null($getEmail) ? 'true' : 'false';
    }

    public function checkSignupEmail(Request $request){
        $getEmail = User::where('email',$request->email)->where('is_delete',0)->first();
        return !is_null($getEmail) ? 'false' : 'true';
    }

    public function authentication(Request $request){
        
        $getEmail = User::where('email',$request->email)->where('is_active',1)->where('is_delete',0)->first();

        if(!is_null($getEmail)){

            $otp = rand (1000,9999);
            //$otp = 1111;

            if($getEmail->is_blocked == 0){

                $updateMail = User::where('id',$getEmail->id)->update(['otp' => $otp]);


                $this->dispatch((new SendLoginOtp($request->email,$otp))->delay(3));

                $res['status'] = 'success';
                $res['message'] = 'OTP successfully sent!';
                $res['email'] = $request->email;

            } else {

                $res['status'] = 'failed';
                $res['message'] = 'Your email is blocked please contact to system admin';
            }

        } else {

            $res['status'] = 'failed';
            $res['message'] = 'Something went wrong!';
        }

        return $res;
    }

    public function resendOtp(Request $request){

        $getEmail = User::where('email',$request->email)->where('is_active',1)->where('is_delete',0)->first();

        if(!is_null($getEmail)){

            $otp = rand (1000,9999);
            //$otp = 1111;
            if($getEmail->is_blocked == 0){

                $updateMail = User::where('id',$getEmail->id)->update(['otp' => $otp]);

                $this->dispatch((new SendLoginOtp($request->email,$otp))->delay(3));

                $res['status'] = 'success';
                $res['message'] = 'OTP successfully sent!';
                $res['email'] = $request->email;
                
            } else {

                $res['status'] = 'failed';
                $res['message'] = 'Your email is blocked please contact to system admin';
            }

        } else {

            $res['status'] = 'failed';
            $res['message'] = 'Something went wrong!';
        }

        return $res;
    }

    public function verifyOtp(Request $request){

        try {
            
            $otp = implode('',$request->otp);

            $getUser = User::where('email',$request->email)->where('otp',$otp)->first();    

            if(!is_null($getUser)){

                if($getUser->is_register == 1){

                    //$this->dispatch((new SendWelcomeMail($request->email,$request->name))->delay(3));

                    $this->sendSmsNotification($getUser->contact_number,'Dear Student, Warm Welcome on completing your Sign up for enrolling in KathakBeats.');

                }

                Auth::login($getUser);

                $res['status'] = 'success';
                $res['message'] = 'Login successfully';

            } else {

                $res['status'] = 'otp_failed';
                $res['message'] = 'Invalid OTP!';
            }

        } catch (Exception $e) {
            
            $res['status'] = 'failed';
            $res['message'] = 'Something went wrong!';
        }

        return $res;
    }

    public function signup(Request $request){

        try{

            $uuid = $this->generateUUID();

            //$otp = 1111;
            $otp = rand (1000,9999);

            $user = new User;
            $user->uuid = $uuid;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->contact_number = $request->contact_number;
            $user->wp_number = $request->whatsapp_contact;
            $user->dob = $request->dob ? date('Y-m-d',strtotime($request->dob)) : null;
            if(isset($request->profile)){
                $filename = $this->uploadBucket($request->profile,'student');
                $user->profile_image = $filename;
            }
            $user->country_id = $this->checkCountry($request->country);
            $user->city_id = $request->city;
            $user->state_id = $request->state;
            $user->address = $request->address;
            $user->state_code = $request->state == 4008 ? 27 : 1200;
            $user->billing_cycle = 'MONTHLY';
            $user->mode = 'ONLINE';
            $user->otp = $otp;
            $user->save();  

            $this->dispatch((new SendLoginOtp($request->email,$otp))->delay(3));

            $res['status'] = 'success';
            $res['message'] = 'OTP successfully sent!';
            $res['email'] = $request->email;

        } catch (Exception $e) {

            $res['status'] = 'failed';
            $res['message'] = 'Something went wrong!';
        }

        return $res;
    }

    public function getStateCode($state_name){

        $state = StateCode::where('id',$state_name)->first();

        return !is_null($state) ? $state->code : 27;
    }

    /**
     * @method index
     * 
     * @description this method is used for user dashboard
     * 
     * */
    public function index(Request $request){


        $userId = Auth::user()->id;
        //
        $isFirstRegister = Auth::user()->is_register == 1 ? 1 : 0;
        if($isFirstRegister == 1){
            $updateUser = User::where('id',$userId)->update(['is_register' => 0]);
        }

        $authData = $request->session()->get('pre_filled_data');

        if(!is_null($authData)){
            $request->session()->forget('pre_filled_data');
            return redirect(route('onlineBatchDetails',$authData['batch_id']));
        }                

        //Get User's batch list
        $getUserBatch = WorkshopStudents::where('student_id',$userId)->pluck('workshop_id')->toArray();

        

        //Get Online batch list
        $getOnlineBatch = Workshop::where([
                                    ['is_active',1],
                                    ['is_delete',0],
                                    ['engagement_type',1],
                                    ['engagement_mode',2],
                                ])
                               ->whereNotIn('id',$getUserBatch)
                               ->with(['workshopstudent'])
                               ->get();
        
        //Get studio batch list
        $getStudioBatch = Workshop::where([
                                    ['is_active',1],
                                    ['is_delete',0],
                                    ['engagement_type',1],
                                    ['engagement_mode',1],
                                ])
                               ->whereNotIn('id',$getUserBatch)
                               ->with(['workshopstudent'])
                               ->get();
        
        //Get workshop list                               
        $getWorkshop = Workshop::where([
                                    ['is_active',1],
                                    ['is_delete',0],
                                    ['engagement_type',2],
                                ])
                               ->whereNotIn('id',$getUserBatch)
                               ->with(['workshopstudent'])
                               ->get();                                                              

    	return view('user.dashboard.dashboard',compact('getWorkshop','getOnlineBatch','getStudioBatch','getWorkshop', 'isFirstRegister'));
    }

    public function checkUserEmail(Request $request){

    }

    public function batches(){

        $userId = Auth::user()->id;

        $studioBatches = Workshop::where('is_active', 1)
                                 ->where('is_delete',0)
                                 ->where('engagement_type',1)
                                 ->where('engagement_mode',1)
                                 ->whereHas('workshopstudent',function($q) use ($userId){
                                     $q->where('student_id', $userId);
                                     $q->where('is_active', 1);
                                 })
                                 ->get();

        
        $onlineBatches = Workshop::where('is_active', 1)
                                 ->where('is_delete',0)
                                 ->where('engagement_type',1)
                                 ->where('engagement_mode',2)
                                 ->whereHas('workshopstudent',function($q) use ($userId){
                                     $q->where('student_id', $userId);
                                     $q->where('is_active', 1);
                                 })
                                 ->get();        

        // echo "<pre>";
        // print_r($onlineBatches->toArray());
        // exit;
    	return view('user.dashboard.batches', compact('onlineBatches','userId','studioBatches'));
    }

    public function studentWorkshop(){

        $userId = Auth::user()->id;

        $studioWorkshop = Workshop::whereHas('workshopstudent',function($q) use ($userId){
                                     $q->where('student_id', $userId);
                                 })->where('engagement_type',2)->where('engagement_mode',1)->where('is_active', 1)->where('is_delete', 0)->get();
        
        $onlineWorkshop = Workshop::whereHas('workshopstudent',function($q) use ($userId){
                                         $q->where('student_id', $userId);
                                    })->where('engagement_type',2)->where('engagement_mode',2)->where('is_active', 1)->where('is_delete', 0)->get();                            
                                    
        return view('user.dashboard.workshop', compact('studioWorkshop','onlineWorkshop','userId'));   
    }

    public function selfLearn(){
        return view('user.dashboard.self_learn');  
    }

    public function notifications(){
    	
    	return view('user.dashboard.notifications');
    }

    public function onlineBatchDetails($uuid){

        $faculty = array();
        $name = array();

        $details = Workshop::where('uuid',$uuid)
                           ->with(['workshopfaculty' => function($q) { $q->with(['faculty']); } ,'workshopstudent','studio','timetable','course'])
                           ->first();
        

        if(!is_null($details->workshopfaculty)){
            foreach($details->workshopfaculty as $fk => $fv){
                if(!is_null($fv->faculty)){
                    $faculty[] = config('constants.awsUrl').'/uploads/profile/'.$fv->faculty->profile_image;
                    $name[] = $fv->faculty->name;
                }
            }
        }                           

        return view('user.dashboard.online_batch_details',compact('details','faculty','name'));
    }

    public function batchDetails($uuid){

        $userId = Auth::user()->id;

        if(Auth::user()->is_active == 1 && Auth::user()->is_delete == 0){


            $batchDetails = Workshop::where('uuid', $uuid)->first();

            $checkStudent = WorkshopStudents::where('workshop_id',$batchDetails->id)->where('student_id',$userId)->first();


            if(!is_null($checkStudent) && $checkStudent->is_active == 1){

                $accessBlock = 1;

                $checkAccess = Invoice::where('user_id',$userId)->where('workshop_id',$batchDetails->id)->orderBy('id','desc')->first();

                //if user has invoice and its status is not paid
                if(!is_null($checkAccess) && $checkAccess->status != 'PAID'){

                    $getUserInvoice = Invoice::where('user_id',$userId)->where('workshop_id',$batchDetails->id)->count();   
                    //check user has more then 1 invoice in particular batch then provide access for 10 days
                    if($getUserInvoice > 1 && date('d') < 11){
                        $accessBlock = 0;
                    } 
                } else {
                    $accessBlock = 0;
                }

                $course = WorkshopCourse::where('workshop_id',$batchDetails->id)
                                        ->with(['course' => function($q){ $q->with(['course']); } ])->get();

                $notes = WorkshopNote::where('user_id',Auth::user()->id)->where('workshop_id',$batchDetails->id)->get();

                if($batchDetails->engagement_type == 1 && $batchDetails->engagement_mode == 1){
                    return view('user.batch.batch_details',compact('batchDetails','course','notes','accessBlock'));
                } else {
                    return view('user.batch.studio_details',compact('batchDetails','course','notes','accessBlock'));
                }
            } else {

                return redirect()->back()->with('messages', [
                    [
                        'type' => 'error',
                        'title' => 'Batch',
                        'message' => 'Your access to this batch / workshop is restricted, please contact admin',
                    ],
                ]);
            }
        } else {
            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Batch',
                    'message' => 'Your access to this batch / workshop is restricted, please contact admin',
                ],
            ]);
        }
    }

    public function profile(){

        $userId = Auth::user()->id;

        $country = Country::all();
        $state = State::all();
        $city = City::all();

        $userProfile = User::where('id',$userId)->with(['city', 'country', 'state', 'workshop'])->first();

        $getUserBatch = WorkshopStudents::where('student_id',$userId)->pluck('workshop_id')->toArray();

        $getStudentWorkshop = WorkshopStudents::where('student_id',$userId)->with(['workshop'])->get();
        
        return view('user.dashboard.profile', compact('userProfile', 'city', 'country', 'state','getStudentWorkshop'));
    }

    public function updateProfile(Request $request){

        $profile = User::findOrFail(Auth::guard('web')->user()->id);
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->contact_number = $request->contact_number;
        $profile->wp_number = $request->wp_number;
        $profile->dob = date('Y-m-d',strtotime($request->dob));
        $profile->country_id = $request->country_id;
        $profile->state_id = $request->state_id;
        $profile->city_id = $request->city_id;
        $profile->address = $request->address;
        if(isset($request->profile_image)){
            $filename = $this->uploadBucket($request->profile_image,'student');
            $profile->profile_image = $filename;
        }
        $profile->save();

        $userProfile = User::where('id', Auth::guard('web')->user()->id)->with(['city', 'country', 'state', 'workshop'])->first();

        return $profile ? $userProfile : 'false';
    }   

    public function saveWorkshopNote(Request $request){

        if(isset($request->id) && $request->id != ''){
            $note = WorkshopNote::findOrFail($request->id);
        } else {
            $note = new WorkshopNote;
        }
        $note->workshop_id = $request->workshop_id;
        $note->user_id = Auth::user()->id;
        $note->title = $request->title;
        $note->notes = $request->description;
        $note->save();

        $notes = WorkshopNote::where('user_id',Auth::user()->id)->where('workshop_id',$request->workshop_id)->get();

        return view('user.dashboard.note_list',compact('notes'));
    }

    public function deleteNote(Request $request){

        $deleteNote = WorkshopNote::where('id',$request->id)->delete();

        return $deleteNote ? 'true' : 'false';
    }

    public function editNote(Request $request){

        $getNoteDetail = WorkshopNote::where('id',$request->id)->first();

        return $getNoteDetail;
    }

    public function editWorkshopNote(Request $request){

        $getNoteData = WorkshopNote::where('id',$request->id)->first();

        return view('user.dashboard.note',compact('getNoteData'));
    }

    //enroll for course
    public function enrollForCourse(Request $request){

        $invoiceId = array();
        $userId = Auth::user()->id;
        $workshopId = base64_decode($request->workshop_id);
        $finalPrice = 0;
        $getWorkshopDetails = Workshop::where('id',$workshopId)->first();

        //check if user already registerd with this workshop
        $getWorkshop = WorkshopStudents::where('student_id',$userId)->where('workshop_id',$workshopId)->first();
        
        if(is_null($getWorkshop)){
            $enroll = new WorkshopStudents;
            $enroll->workshop_id = $workshopId;
            $enroll->student_id = $userId;
            $enroll->invoice_cycle = 'MONTHLY';
            $enroll->is_active = 0;
            $enroll->save();

            $duration = 1;

            $payment['user_id'] = $userId;
            $payment['workshop_id'] = $workshopId;
            $payment['duration'] = $duration;
            $payment['cycle'] = Auth::user()->billing_cycle;
            $payment['discount'] = 0;
            $payment['medium'] = 0;
            $payment['mode'] = 2;
            $payment['payment_method'] = 2;
            $payment['payment_remarks'] = '';
            $payment['price'] = $this->countBatchPrice($getWorkshopDetails->price,$duration,Auth::user()->state_code);

            $invoiceId = $this->addPaymentEntry($payment,$getWorkshopDetails);

            $finalPrice = $payment['price']['total_price'];

        } else {

            $getInvoiceId = Invoice::where('workshop_id',base64_decode($request->workshop_id))->where('user_id',$userId)->orderBy('id','desc')->first();
            $finalPrice = $getInvoiceId->amount;
            $invoiceId['invoice_id'] = $getInvoiceId->id;
        }

        // $message = 'Dear Student, you have successfully registered yourself for '.$getWorkshopDetails->title.' which will commence from '.$getWorkshopDetails->start_date.', Team KathakBeats';

        // $this->sendSmsNotification(Auth::user()->contact_number,$message);

        $data['uuid'] = $getWorkshopDetails->uuid;
        $data['workshop_name'] = $getWorkshopDetails->title;
        $data['short_description'] = $getWorkshopDetails->short_description;
        $data['price'] = $getWorkshopDetails->price;
        $data['is_payment'] = $getWorkshopDetails->engagement_mode == 1 ? true : false;
        $data['name'] = Auth::user()->name;
        $data['price'] = $finalPrice;
        $data['email'] = Auth::user()->email;
        $data['phone'] = Auth::user()->contact_number;
        $data['id'] = Auth::user()->id;
        $data['invoice_id'] = count($invoiceId) > 0 ? $invoiceId['invoice_id'] : '';

        if($request->type == 'paypal'){
            $link = $this->postPaymentWithpaypal($data,'MONTHLY');
            $data['link'] = $link;
        } 
        return $data;
    }

    //payment for remaining invoice
    public function remainingInvoicePayment(Request $request){

        $getInvoiceId = Invoice::where('id',base64_decode($request->invoice_id))->with(['workshop'])->first();


        if(!is_null($getInvoiceId)){

            //invoice data
            $data['invoice_id'] = $getInvoiceId->id;
            $data['price'] = $getInvoiceId->amount;

            //workshop
            $data['uuid'] = $getInvoiceId->workshop->uuid;
            $data['workshop_id'] = $getInvoiceId->workshop->id;
            $data['workshop_name'] = $getInvoiceId->workshop->title;
            $data['short_description'] = $getInvoiceId->workshop->short_description;
            $data['is_payment'] = $getInvoiceId->workshop->engagement_mode == 1 ? true : false;

            //userdata
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
            $data['phone'] = Auth::user()->contact_number;
            $data['id'] = Auth::user()->id;

            if($request->type == 'paypal'){
                $link = $this->postPaymentWithpaypal($data,$getInvoiceId->payment_cycle);
                $data['link'] = $link;
            } 

            return $data;

        } else {

            $data['status'] = 500;
            $data['message'] = 'Something went wrong';

            return $data;
        }
    }
    
    public function leaveBatch(Request $request){

        $unlinkBatch = WorkshopStudents::where('workshop_id',base64_decode($request->workshop_id))
                        ->where('student_id',Auth::user()->id)->delete();

        $data['status'] = $unlinkBatch ? 'true' : 'false';

        return $data;
    }

    public function clearNotification(){

        $notification = Notification::where('user_id',Auth::user()->id)->delete();

        return $notification ? 'true' : 'false';
    }

    public function postPaymentWithpaypal($data,$interval){
       
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $intervalPrice =  $interval == 'MONTHLY' ? 100 : 300;

        $price = $data['price'] + $intervalPrice;
        $usdPrice = ExchangeData::where('key','USD')->first();
        $courseFees = $price / $usdPrice->price;

        //item one
        $item_1->setName($data['workshop_name'])
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($courseFees);

        //item object
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        //amount object
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($courseFees);
        
        //transaction             
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($data['short_description']);
        
        //redirect url            
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('getPaymentStatus'))
            ->setCancelUrl(route('getPaymentStatus'));

        //payment
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));            

        //create payment intent    
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                return Redirect::route('payment');
            } else {
                return Redirect::route('payment');
            }
        }

        //get payment link
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        
        //set paypal payment id into session
        Session::put('paypal_payment_id', $payment->getId());

        if(isset($redirect_url)) {
            //add invoice id into session
            Session::put('invoice_id',$data['invoice_id']);
            return $redirect_url;
        }

        \Session::put('error','Unknown error occurred');
        return Redirect::route('paywithpaypal');
    }
}
