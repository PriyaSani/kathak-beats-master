@extends('layouts.admin')
@section('title','View Invoice')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        View Invoice
    </h2>
</div>
<div class="grid grid-cols-12 gap-6">
	<div class="col-span-12 lg:col-span-6 xxl:col-span-6">
	    <form class="custom-validation" action="{{ route('admin.generateInvoice') }}" method="post" enctype="multipart/form-data">
		@csrf
        <div class="intro-y box lg:mt-5">
            <div class="p-5">
                <div class="mt-3">
                    <label>Invoice No<span class="mandatory">*</span></label>
                    <input type="tel" name="invoice_number" class="input w-full border form-control mt-2 numeric" placeholder="Invoice No" value="{{ $getInvoice->invoice_number }}" disabled />
                </div>

                <div class="mt-3">
                    <label>Order No<span class="mandatory">*</span></label>
                    <input type="text" name="order_number" class="input w-full border form-control mt-2" placeholder="Order No" value="{{ $getInvoice->order_number }}" disabled />
                </div>

                <div class="mt-3">
                    <label>Invoice Date<span class="mandatory">*</span></label>
                    <input type="text" name="invoice_date" class="ndatepicker input w-full border form-control mt-2 numeric priority" placeholder="Invoice Date" autocomplete="off" value="{{ date('d/m/Y',strtotime($getInvoice->invoice_date)) }}" disabled/>
                </div>	

                <div class="mt-3">
                    <label>KB State<span class="mandatory">*</span></label>
                    <input type="text" name="kb_state" class="input w-full border form-control mt-2" placeholder="KB State" value="Maharashtra" readonly />
                </div>	

                <div class="mt-3">
                    <label>Select Batch/Workshop<span class="mandatory">*</span></label>
                    <select data-placeholder="Select Batches" name="batch_id" data-search="true" class="inBatch menulist form-control w-full" disabled="">
                        <option value="">Select Batch/Workshop</option>
                        @if(!is_null($workShop))
                            @foreach($workShop as $wk => $wv)
                                <option value="{{ $wv->id }}" @if($wv->id == $getInvoice->workshop_id) selected="selected" @endif>{{ $wv->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

            </div>
        </div>
	</div>
    <div class="col-span-12 lg:col-span-6 xxl:col-span-6">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="p-5">

            	<div class="mt-3">
                    <label>Select Student<span class="mandatory">*</span></label>
                    <input type="text" name="student_name" class="input w-full border form-control mt-2" id="student" placeholder="Search Student" value="{{ $getInvoice->user->name }}" disabled/>
                    <input type="hidden" name="student_id" value="" id="student_id">
                </div>

                <div class="mt-3">
                    <label>Name</label>
                    <input type="text" name="name" class="input w-full border form-control mt-2" placeholder="Name" id="name" value="{{ $getInvoice->user->name }}" readonly />
                </div>

                 <div class="mt-3">
                    <label>Address</label>
                    <input type="text" name="address" class="input w-full border form-control mt-2 numeric" id="address"  placeholder="Invoice No" value="{{ $getInvoice->user->address }}" readonly />
                </div>

                 <div class="mt-3">
                    <label>Phone Number</label>
                    <input type="tel" name="phone_number" class="input w-full border form-control mt-2 numeric" id="phone_number"  placeholder="Phone Number" value="{{ $getInvoice->user->contact_number }}" disabled="" />
                </div>

                <div class="mt-3">
                    <label>State</label>
                    <input type="text" name="state" class="input w-full border form-control mt-2 numeric"  id="state" placeholder="State" value="{{ $getInvoice->user->state->name }}" disabled="" />
                </div>

                <div class="mt-3">
                    <label>Country</label>
                    <input type="text" name="country" class="input w-full border form-control mt-2 numeric" id="country" placeholder="Country" value="{{ $getInvoice->user->country->name }}" disabled="" />
                </div>

                <div class="mt-3">
                    <label>Payment Cycle<span class="mandatory">*</span></label>
                    <select data-placeholder="Select Batches" name="payment_cycle" id="invoice_payment_cycle" data-search="true" class="menu-list form-control w-full" disabled>
                        <option value="">Select Payment Cycle</option>
                        <option value="MONTHLY" @if($getInvoice->payment_cycle == 'MONTHLY') selected="seletected" @endif>Monthly</option>
                        <option value="QUARTERLY" @if($getInvoice->payment_cycle == 'QUARTERLY') selected="seletected" @endif>Quarterly</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label>Payment Method<span class="mandatory">*</span></label>
                    <select data-placeholder="Select Batches" name="payment_method" data-search="true" id="invoice_payment_method" class="form-control menu-list w-full" disabled>
                        <option value="">Select Payment Method</option>
                        <option value="1" @if($getInvoice->payment_method == 1) selected="selected" @endif>Cash</option>
                        <option value="2" @if($getInvoice->payment_method == 2) selected="selected" @endif>Online/UPI</option>
                        <option value="3" @if($getInvoice->payment_method == 3) selected="selected" @endif>Cheque</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label>Payment Remarks</label>
                    <textarea class="w-full form-control mt-2" name="payment_remarks" placeholder="Enter Txn reference no, cheque no etc." disabled>{{ $getInvoice->payment_remarks }}</textarea>
                </div>

                <div class="monthly hide">
                    <div class="mt-3">
                        <label>Month<span class="mandatory">*</span></label><br/>
                        <select data-placeholder="Select Batches" name="month" data-search="true" class="form-control col-span-3">
                            <option value="">Select Payment Cycle</option>
                            <option value="MONTHLY">Monthly</option>
                            <option value="QUARTERLY">Quarterly</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Year<span class="mandatory">*</span></label><br/>
                        <select data-placeholder="Select Batches" name="year" data-search="true" class="form-control col-span-3">
                            <option value="">Select Payment Cycle</option>
                            @if(!is_null($year))
                                @foreach($year as $yk => $yv)
                                    <option value="{{ $yv }}">{{ $yv }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="quartely hide">
                    <div class="mt-3">
                        <label>Quater<span class="mandatory">*</span></label><br/>
                        <select data-placeholder="Select Batches" name="month" data-search="true" class="form-control col-span-3">
                            <option value="">Select Payment Cycle</option>
                            <option value="APRIL-JUNE">April to June</option>
                            <option value="JULY-SEPTEMBER">July to September</option>
                            <option value="JULY-SEPTEMBER">October to December</option>
                            <option value="JULY-SEPTEMBER">January to March</option>
                        </select>
                    </div>            

                    <div class="mt-3">
                        <label>Year<span class="mandatory">*</span></label><br/>
                        <select data-placeholder="Select Batches" name="year" data-search="true" class="form-control col-span-3">
                            <option value="">Select Payment Cycle</option>
                            @if(!is_null($year))
                                @foreach($year as $yk => $yv)
                                    <option value="{{ $yv }}">{{ $yv }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                    
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
    <div class="col-span-12 lg:col-span-12 xxl:col-span-6">
        <div class="mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <!-- <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Sr.No</th> -->
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Particulars</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">QTY</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Fees</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">HSN</th>
                        <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Total</th>
                    </tr>
                </thead>
                <tbody class="invoice_row">
                @if(!is_null($getInvoice->invoice_details))
                    @foreach($getInvoice->invoice_details as $ik => $iv)
                        <tr>
                            <!-- <td class="border">1</td> -->
                            <td class="border">
                                <input type="text" name="data[0][title]" class="form-control inTitle widthFifty" value="{{ $iv->perticulars }}" disabled>
                            </td>
                            <td class="border">
                                <input type="number" name="data[0][qty]" class="form-control widthFifty inqty qty numeric qty0" data-id="0" value="{{ $iv->qty }}" disabled>
                            </td>
                            <td class="border">
                                <input type="text" name="data[0][fees]" class="form-control widthFifty fees numeric fees0"  data-id="0" value="{{ $iv->fees }}" disabled>
                            </td>
                            <td class="border">
                                <input type="text" name="data[0][hsn]" class="form-control widthFifty numeric" value="{{ $iv->hsn }}" disabled>
                            </td>
                            <td class="border">
                                <input type="text" name="data[0][total]" class="form-control widthFifty total numeric total0"  data-id="0" value="{{ $iv->total }}" disabled>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-6 xxl:col-span-6">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="p-5">

                <div class="mt-3">
                    <label>Total Amount</label>
                    <input type="text" name="total_amount" class="input w-full border form-control mt-2 grandTotal numeric" placeholder="Total Amount"  value="{{ $getInvoice->amount }}" readonly="" />
                </div>

                <div class="mt-3">
                    <label>Roundoff</label>
                    <input type="text" name="round_off" id="round_off" class="input w-full border form-control mt-2" placeholder="Roundoff" value="{{ $getInvoice->round_off }}" disabled="" />
                </div>

            </div>
        </div>
        <!-- END: Change Password -->
    </div>
    <div class="col-span-12 lg:col-span-6 xxl:col-span-6">
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="p-5">

                <div class="mt-3">
                    <label>Total in Words</label>
                    <input type="text" name="total_in_words" class="input w-full border form-control mt-2 numeric" id="totalInWords" placeholder="Total in Words"  value="{{ $getInvoice->amount_words }}" disabled />
                </div>

                <div class="mt-3">
                    <label>T&C</label>
                    <textarea class="w-full form-control mt-2" name="terms_and_conditions" placeholder="Terms and conditions" disabled="">{{ $getInvoice->terms_and_conditions }}</textarea>
                </div>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
    </form>
</div>
@endsection
