<?php

namespace App\Http\Controllers;

use App\Jobs\BatchEnrollment;
use App\Jobs\PaymentNotification;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WorkshopStudents;
use Auth;
use Illuminate\Http\Request;
use PDF;
use Razorpay\Api\Api;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Session;

class PaymentController extends GlobalController
{
    private $_api_context;

    public function __construct(){
        
        $this->middleware('auth');
        
        /////////////////////////////////live/////////////////////////////////
        //AT2J7AoDBqCfcthxWnUXRTBEY2_n2CzDtY5RIT90yDa_1d-plteQrKMomUeIYxVAC3T3cWMOrSH28eC0
        //EJIfkSSvv3hIhFtOiGmeExmL2ZSKNYMc72JPlngydFqegJ_qxeg3zzoQAuOAcSMw7qz-tlJh9ICvJmpq
        
        /////////////////////////////////sandbox/////////////////////////////////
        //AaQs5MVFjfmTTE3aoW-MHpcW6etoSyZ9qoQ1VT80wmfZmUFSQ6IdcSXIRyc4zHrrmBkFp4-27T4aH1CT
        //EPlKQMoVdWbiz-q4ic8yDYX_DOL-moCKdmDL9HdH9M6sB44QSxDO9NL4KAEucrUF2FqdYZtizuYTg__Z
        
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

    /**
     * 
     * @method payment 
     * 
     * @description Get user payment page
     * 
     */
    public function payment(){

        $getStudent = WorkshopStudents::where('student_id',Auth::user()->id)->with(['workshop','users'])->get();

        $getInvoice = Invoice::where('user_id',Auth::user()->id)->whereNull('invoice_date')->with(['workshop','user'])->get();

        $getPaidInvoice = Invoice::where('user_id',Auth::user()->id)->where('is_delete',0)->where('status','PAID')->whereNotNull('invoice_date')->with(['workshop','user'])->get();

        return view('user.payment.payment',compact('getStudent','getInvoice','getPaidInvoice'));
    }

    public function getInvoiceFilter(Request $request){

        $type = $request->type;

        $query = Invoice::where('user_id',Auth::user()->id)->whereNotNull('invoice_date');
        if(isset($request->start_date) && $request->start_date != ''){
            $query->whereDate('invoice_date','>=',date('Y-m-d',strtotime($request->start_date)));
        }
        if(isset($request->end_date) && $request->end_date != ''){
            $query->whereDate('invoice_date','<=',date('Y-m-d',strtotime($request->end_date)));   
        }
        if($request->type == 'invoice'){
            $query->where('status','invoice');
        }
        $getInvoice = $query->with(['workshop','user'])->get();

        return view('user.payment.filter',compact('getInvoice','type'));
    }

    /**
     * 
     * @method paymentSuccess
     * 
     * @description update payment success reponse 
     *
     */
    public function paymentSuccess(Request $request){

        $data = $request->all();

        \Log::info($data);

        try {
            
            $publickey = env('RAZORPAY_KEY','rzp_live_vS9h88M8j6DSm9');
            $secretkey = env('RAZORPAY_SECRET','O0uabZHlUkA6Gbf74rCSVk4Q');
            // $publickey = env('RAZORPAY_KEY','rzp_test_X6T2aZNj2pMj0h');
            // $secretkey = env('RAZORPAY_SECRET','X0X8Lob1dinRoiO8c0BF6ate');

            $api = new Api($publickey,$secretkey);

            $paymentId = $data['response']['razorpay_payment_id'];
            $amount = $data['amount'] * 100;

            //capture payment from razorpay
            $response = $api->payment->fetch($paymentId)->capture(array('amount'=> $amount)); 

            $payload = $response->toArray();

            \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");
            \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");
            \Log::channel('paymentlog')->error("Function: Payment Information from payment controller");
            \Log::channel('paymentlog')->error("Stack: ".$payload);
            \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");
            \Log::channel('paymentlog')->error("------------------------------------------------------------------------------------------");

            //update data
            $pdfName = date('dmyhis').'.pdf';

            $amount = $data['amount'];

            //update invoice table
            $invoice = Invoice::findOrFail(base64_decode($data['invoice_id']));
            $invoice->invoice_date = date('Y-m-d');
            $invoice->file = $pdfName;
            $invoice->transaction_id = $paymentId;
            $invoice->status = 'PAID';
            $invoice->save();

            $getUserInfo = User::where('id',Auth::user()->id)->first();

            //get data from invoice
            $getInvoiceDetail = Invoice::where('id',base64_decode($data['invoice_id']))
                                       ->with(['user' => function($q) { $q->with(['state']); } ,'workshop'])
                                       ->first();
            
            //generate invoice                                           
            $pdf = PDF::loadView('pdf.invoice', compact('getInvoiceDetail','getUserInfo'));

            $path = "/uploads/invoice/".$pdfName;

            \Storage::disk('s3')->put($path, $pdf->output(), 'public-read');

            if(!is_null($getUserInfo)){

                $checkForPendingInvoice = Invoice::where('workshop_id',base64_decode($data['workshop_id']))->where('user_id',Auth::user()->id)->where('status','PENDING')->first();

                if(is_null($checkForPendingInvoice)){
                    $updateUserAccess  = WorkshopStudents::where('workshop_id',base64_decode($data['workshop_id']))
                                                         ->where('student_id',Auth::user()->id)
                                                         ->update(['is_active' => 1]);
                } 

                $message = 'Dear Student, your payment towards KathakBeats has been successful. Please check your registered email id.';

                //$this->sendSmsNotification($getUserInfo->contact_number,$message);
                if($getUserInfo->is_blocked == 0){
                    $this->dispatch((new PaymentNotification($getUserInfo->email,$amount,$response['id']))->delay(5));        
                }
                

                $invoiceCount = Invoice::where('workshop_id',$getInvoiceDetail->workshop_id)
                                   ->where('user_id',$getInvoiceDetail->user_id)                                
                                   ->count();
                                   
                if($invoiceCount == 1){
                    $this->dispatch((new BatchEnrollment($getInvoiceDetail->user->name,$getInvoiceDetail->workshop->title,$getInvoiceDetail->user->email))->delay(5));                    
                }    
            }


            return 'true';

        } catch (Exception $e) {

            return  $e->getMessage();
        }
    }

    public function getPaymentStatus(Request $request){        
        
        //paypal_payment_id        
        $payment_id = Session::get('paypal_payment_id');
        $invoiceId = Session::get('invoice_id');

        //remove id from paypal
        Session::forget('paypal_payment_id');
        Session::forget('invoice_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            return redirect(route('payment'));
        }

        //get payment instance
        $payment = Payment::get($payment_id, $this->_api_context);        

        //payment execution
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));        

        $result = $payment->execute($execution, $this->_api_context);

        //get payment status approved
        if ($result->getState() == 'approved') {         
            
            $paymentId = $result->transactions[0]->related_resources[0]->sale->id;
            $amount = $result->transactions[0]->amount->total;

            $pdfName = date('dmyhis').'.pdf';

            //update invoice table
            $invoice = Invoice::findOrFail($invoiceId);
            $invoice->invoice_date = date('Y-m-d');
            $invoice->file = $pdfName;
            $invoice->transaction_id = $paymentId;
            $invoice->status = 'PAID';
            $invoice->save();
                
            $getUserInfo = User::where('id',Auth::user()->id)->first();

            //get data from invoice
            $getInvoiceDetail = Invoice::where('id',$invoiceId)
                                       ->with(['user' => function($q) { $q->with(['state']); } ,'workshop'])
                                       ->first();
            
            //generate invoice                                           
            $pdf = PDF::loadView('pdf.invoice', compact('getInvoiceDetail','getUserInfo'));

            $path = "/uploads/invoice/".$pdfName;

            \Storage::disk('s3')->put($path, $pdf->output(), 'public-read');

            if(!is_null($getUserInfo)){

                $message = 'Dear Student, your payment towards KathakBeats has been successful. Please check your registered email id.';

                //$this->sendSmsNotification($getUserInfo->contact_number,$message);
                if($getUserInfo->is_blocked == 0){
                    $this->dispatch((new PaymentNotification($getUserInfo->email,$amount,$paymentId))->delay(5));        
                }

                $invoiceCount = Invoice::where('workshop_id',$getInvoiceDetail->workshop_id)
                                   ->where('user_id',$getInvoiceDetail->user_id)                                
                                   ->count();
                                   
                if($invoiceCount == 1){
                    $this->dispatch((new BatchEnrollment($getInvoiceDetail->user->name,$getInvoiceDetail->workshop->title,$getInvoiceDetail->user->email))->delay(5));                    
                }    
            }

            return redirect(route('payment'));
        }

        return redirect(route('payment'));
    }
}
