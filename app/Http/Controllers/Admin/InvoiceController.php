<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\GlobalController;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends GlobalController
{
    public function __construct(){
        $this->middleware('admin');
        //$this->middleware('checkpermission');
    }

    public function invoiceList(Request $request){

        
        $filter = 0;
        $paymentCycle = '';
        $studentName = '';
        $batchName = '';
        $paymentMedium = '';
        $paymentMode = '';
        $financialYear = '';
        $invoiceDate = '';

        $mode = array('1' => 'Cash','2' => 'Online/UPI','3' => 'Cheque');

        $query = Invoice::where('is_active', 1)->where('is_delete', 0);

        if(isset($request->year) && $request->year != ''){
            $filter = 1;
            $financialYear = $request->year;
            $query->where('invoice_date',$financialYear);
        }

        if(isset($request->payment_cycle) && $request->payment_cycle != ''){
            $filter = 1;
            $paymentCycle = $request->payment_cycle;
            $query->where('payment_cycle',$paymentCycle);
        }

        if(isset($request->invoice_date_range)){
            $filter = 1;
            $invoiceDate = $request->invoice_date_range;
            $date = explode('-',$request->invoice_date_range);
            $date1 = date('Y-m-d',strtotime($this->convertDate($date[0])));
            $date2 = date('Y-m-d',strtotime($this->convertDate(trim($date[1]))));
            $query->whereDate('invoice_date','>=',$date1);
            $query->whereDate('invoice_date','<=',$date2);
        }

        if(isset($request->student_name) && $request->student_name != ''){
            $filter = 1;
            $studentName = $request->student_name;
            $query->whereHas('user', function($q) use($studentName){ $q->where('id',$studentName);});
        }

        if(isset($request->batch_name) && $request->batch_name != ''){
            $filter = 1;
            $batchName = $request->batch_name;
            $query->whereHas('workshop', function($q) use($batchName){ $q->where('id',$batchName);});
        }

        if(isset($request->payment_medium) && $request->payment_medium != ''){
            $filter = 1;
            $paymentMedium = $request->payment_medium;
            $query->where('medium', $paymentMedium);
        }

        if(isset($request->payment_mode) && $request->payment_mode != ''){
            $filter = 1;
            $paymentMode = $request->payment_mode;
            $query->where('medium', $paymentMode);
        }

        $query->where('status','PAID');
        $query->orderBy('id','desc');
        $getInvoice = $query->with(['workshop','user'])->get();

        return view('admin.invoice.invoice_list',compact('getInvoice','mode', 'filter', 'paymentCycle', 'studentName', 'batchName', 'paymentMedium', 'paymentMode', 'financialYear','invoiceDate'));
    }

    public function getYear(){
        
        $startdate = 2021;
        $enddate = date("Y");
        $years = range($startdate,$enddate);
        $y = array();
        //print years
        foreach($years as $year){
            $y[] = $year.' - '.($year + 1);
        }

        return $y;
    }

    public function financialYear(){

        $year = date('Y');
        $month = date('m');
        if($month<4){
            $year = $year - 1;
        }
        return substr($year, 2).'-'.substr(($year + 1),2);
    }

    public function addInvoice(){

        $year = $this->getYear();

        $getInvoice = Invoice::orderBy('id','desc')->where('medium',2)->first();

        $invoice = !is_null($getInvoice) ? $getInvoice->number + 1 : 1;

        $orderNumber = "KB/".$this->financialYear()."/".($invoice);

        $invoiceNumber = "KB/OFL/".$this->financialYear()."/".($invoice);
    	
    	$workShop = Workshop::all();

    	return view('admin.invoice.add_invoice',compact('workShop','orderNumber','invoiceNumber','year','invoice'));
    }

    public function getStudentJson(Request $request){

    	$user = User::where('is_active',1)->where('is_delete',0)->get();

    	$userJson = array();

    	if(!is_null($user)){
    		foreach($user as $uk => $uv){
    			$userJson[$uk]['label'] = $uv->name;
    			$userJson[$uk]['value'] = $uv->id;
    		}
    	}

    	return $userJson;
    }

    public function getStudentDetails(Request $request){

    	$getUserDetails = User::where('id',$request->id)->with(['city','state','country'])->first()->toArray();

    	return $getUserDetails;
    }	

    public function generateInvoice(Request $request){


        $data = $request->all();

        $pdfName = date('dmyhis').'.pdf';
        
        $invoice = new Invoice;
        $invoice->invoice_number = $request->invoice_number;
        $invoice->order_number = $request->order_number;
        $invoice->number = $request->invoice;
        $invoice->invoice_date = $this->convertDate($request->invoice_date);
        $invoice->workshop_id = $request->batch_id;
        $invoice->user_id = $request->student_id;
        $invoice->kb_state = $request->kb_state;
        $invoice->payment_cycle = $request->payment_cycle;
        $invoice->payment_method = $request->payment_method;
        $invoice->payment_remarks = $request->payment_remarks;
        $invoice->amount_words = $request->total_in_words;
        $invoice->discount = $request->discount;
        $invoice->medium = 2;
        $invoice->mode = 2;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
        $invoice->month = $request->month;
        $invoice->year = $request->year;

        $invoiceData = $this->countInvoiceSummery($request->total_amount);

        //count
        $invoice->round_off = $request->round_off;
        $invoice->amount = $request->total_amount;
        $invoice->base_price = $invoiceData['basePrice'];
        $invoice->sgst_per = $invoiceData['sgst_per'];
        $invoice->cgst_per = $invoiceData['cgst_per'];
        $invoice->igst_per = $invoiceData['igst_per'];
        $invoice->sgst_amount = $invoiceData['sgst_amount'];
        $invoice->cgst_amount = $invoiceData['cgst_amount'];
        $invoice->igst_amount = $invoiceData['igst_amount'];
        //count
        
        $invoice->file = $pdfName;
        $invoice->status = 'PAID';
        $invoice->save();

        if(!is_null($request->data)){
            foreach($request->data as $dk => $dv){
                $detail = new InvoiceDetail;
                $detail->invoice_id = $invoice->id;
                $detail->perticulars = $dv['title'];
                $detail->qty = $dv['qty'];
                $detail->fees = $dv['fees'];
                $detail->hsn = $dv['hsn'];
                $detail->total = $dv['total'];
                $detail->save();
            }
        }

        $user = User::where('id',$request->student_id)->first();
        
        $pdf = PDF::loadView('admin.pdf.invoice', compact('data','user'));

        // return $pdf->stream('download.pdf');

        // exit;

        $path = "/uploads/invoice/".$pdfName;

        \Storage::disk('s3')->put($path, $pdf->output(), 'public-read');

        $route = $request->btn_submit == 'save_and_add_new' ? 'admin.addInvoice' : 'admin.invoiceList';

        return redirect(route($route))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Invoice',
                'message' => 'Invoice successfully generated',
            ],
        ]);      

    }

    public function countInvoiceSummery($amount,$state_code = 22){

        $sgst_per = 9;
        $sgst_amount = 0;
        $cgst_per = 9;
        $cgst_amount = 0;
        $igst_per = 18;
        $igst_amount = 0;
        $totalPrice = 0;

        $totalGst = 100 + 18;

        $basePrice = (100 * $amount) / $totalGst; 

        $sgst_amount = ($amount - $basePrice) / 2;
        $cgst_amount = ($amount - $basePrice) / 2;
        $igst_amount = $sgst_amount + $cgst_amount;
               
        $round = 0;

        $data['sgst_per'] = $sgst_per;
        $data['cgst_per'] = $cgst_per;
        $data['igst_per'] = $igst_per;
        $data['sgst_amount'] = $sgst_amount;
        $data['cgst_amount'] = $cgst_amount;
        $data['igst_amount'] = $igst_amount;
        $data['basePrice'] = $basePrice;
        $data['roundValue'] = 0;
        $data['total_price'] = $amount;

        return $data;
    }

    public function viewInvoice($id){

        $year = $this->getYear();
        
        $workShop = Workshop::all();

        $getInvoice = Invoice::where('id',base64_decode($id))->with(['invoice_details','user' => function($q){ $q->with(['country','state']); } ])->first();

        return view('admin.invoice.view_invoice',compact('getInvoice','workShop','year'));
    }

    public function editInvoice($id){

        $year = $this->getYear();
        
        $workShop = Workshop::all();

        $getInvoice = Invoice::where('id',$id)->with(['workshop','user','invoice_details'])->first();

        return view('admin.invoice.edit_invoice',compact('getInvoice','workShop','year'));
    }

    public function saveEditedInvoice(Request $request){


        $data = $request->all();

        $pdfName = date('dmyhis').'.pdf';

        $invoice = Invoice::findOrFail($request->id);
        $invoice->invoice_number = $request->invoice_number;
        $invoice->order_number = $request->order_number;
        //$invoice->number = 2;
        $invoice->invoice_date = $this->convertDate($request->invoice_date);
        $invoice->workshop_id = $request->batch_id;
        $invoice->user_id = $request->student_id;
        $invoice->kb_state = $request->kb_state;
        $invoice->payment_cycle = $request->payment_cycle;
        $invoice->payment_method = $request->payment_method;
        $invoice->payment_remarks = $request->payment_remarks;
        $invoice->amount_words = $request->total_in_words;
        $invoice->round_off = $request->round_off;
        $invoice->amount = $request->total_amount;
        $invoice->base_price = $request->total_amount + $request->discount;
        $invoice->medium = 2;
        $invoice->mode = 2;
        $invoice->terms_and_conditions = $request->terms_and_conditions;
        if($request->payment_cycle == 'MONTHLY'){
            $invoice->month = $request->month;
            $invoice->year = $request->myear;
        } else {
            $invoice->month = $request->quater;
            $invoice->year = $request->qyear;
        }
        $invoice->file = $pdfName;
        $invoice->update();

        if(!is_null($request->data)){
            foreach($request->data as $dk => $dv){
                if(isset($dv['invoice_detail_id'])){
                    $detail = InvoiceDetail::findOrFail($dv['invoice_detail_id']);
                } else {
                    $detail = new InvoiceDetail;
                }
                $detail->invoice_id = $invoice->id;
                $detail->perticulars = $dv['title'];
                $detail->qty = $dv['qty'];
                $detail->fees = $dv['fees'];
                $detail->hsn = $dv['hsn'];
                $detail->total = $dv['total'];
                $detail->save();
            }
        }

        $user = User::where('id',$request->student_id)->first();

        $pdf = PDF::loadView('admin.pdf.invoice', compact('data','user'));

        $path = "/uploads/invoice/".$pdfName;

        \Storage::disk('s3')->put($path, $pdf->output(), 'public-read');

        return redirect(route('admin.invoiceList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Invoice',
                'message' => 'Invoice details successfully updated',
            ],
        ]);  

    }

    public function deleteInvoice($id){

        $deleteInvoice = Invoice::where('id', $id)->update(['is_delete' => 1]);

        return redirect(route('admin.invoiceList'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Invoice',
                'message' => 'Invoice successfully deleted',
            ],
        ]);

    }

    public function linkList(){

        return view('admin.invoice.link_list');
    }
}
