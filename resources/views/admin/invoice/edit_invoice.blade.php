@extends('layouts.admin')
@section('title','Edit Invoice')
@section('content')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Invoice
    </h2>
</div>
<form class="custom-validation" action="{{ route('admin.saveEditedInvoice') }}" method="post" enctype="multipart/form-data" id="addInvoice">
@csrf
    <div class="grid grid-cols-12 gap-6">
    	<div class="col-span-12 lg:col-span-6 xxl:col-span-6">
    	    
            <div class="intro-y box lg:mt-5">
                <div class="p-5">
                    <input type="hidden" name="id" id="id" value="{{ $getInvoice->id }}">
                    <div class="mt-3">
                        <label>Invoice No</label>
                        <input type="tel" name="invoice_number" class="input w-full border form-control mt-2" placeholder="Invoice No" value="{{ $getInvoice->invoice_number }}" />
                    </div>

                    <div class="mt-3">
                        <label>Order No</label>
                        <input type="text" name="order_number" class="input w-full border form-control mt-2" placeholder="Order No" value="{{ $getInvoice->order_number }}" />
                    </div>

                    <div class="mt-3">
                        <label>Invoice Date</label>
                        <input type="text" name="invoice_date" class="ndatepicker input w-full border form-control mt-2 numeric priority" placeholder="Invoice Date" autocomplete="off" value="{{ date('d/m/Y', strtotime($getInvoice->invoice_date)) }}"/>
                    </div>	

                    <div class="mt-3">
                        <label>KB State</label>
                        <input type="text" name="kb_state" class="input w-full border form-control mt-2" placeholder="KB State" value="{{ $getInvoice->kb_state }}" readonly />
                    </div>	

                    <div class="mt-3">
                        <label>Select Batch/Workshop<span class="mandatory">*</span></label>
                        <select data-placeholder="Select Batches" name="batch_id" data-search="true" class="inBatch menulist form-control w-full">
                            <option value="">Select Batch/Workshop</option>
                            @if(!is_null($workShop))
                                @foreach($workShop as $wk => $wv)
                                    <option  @if($getInvoice->workshop_id == $wv->id) selected @endif value="{{ $wv->id }}">{{ $wv->title }}</option>
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
                        <label>Search Student</label>
                        <input type="text" name="student_name" class="input w-full border form-control mt-2" id="student" placeholder="Search Student" value="{{ $getInvoice->user->name }}"/>
                        <input type="hidden" name="student_id" value="{{ $getInvoice->user->id }}"  id="student_id">
                    </div>

                    <div class="mt-3">
                        <label>Name</label>
                        <input type="text" name="name" class="input w-full border form-control mt-2" placeholder="Name" id="name" value="{{ $getInvoice->user->name }}" readonly />
                    </div>

                     <div class="mt-3">
                        <label>Address</label>
                        <input type="text" name="address" class="input w-full border form-control mt-2 numeric" id="address"  placeholder="Invoice No" value="{{ $getInvoice->user->address }}" />
                    </div>

                     <div class="mt-3">
                        <label>Phone Number</label>
                        <input type="tel" name="phone_number" class="input w-full border form-control mt-2 numeric" id="phone_number"  placeholder="Phone Number" value="{{ $getInvoice->user->contact_number }}" />
                    </div>

                    <div class="mt-3">
                        <label>State</label>
                        <input type="text" name="state" class="input w-full border form-control mt-2 numeric"  id="state" placeholder="State" value="{{ $getInvoice->user->address }}" />
                    </div>

                    <div class="mt-3">
                        <label>Country</label>
                        <input type="text" name="country" class="input w-full border form-control mt-2 numeric" id="country" placeholder="Country" value="{{ $getInvoice->user->country_id }}" />
                    </div>

                    <div class="mt-3">
                        <label>Payment Cycle<span class="mandatory">*</span></label>
                        <select data-placeholder="Select Batches" name="payment_cycle" id="invoice_payment_cycle" data-search="true" class="menu-list form-control w-full">
                            <option value="">Select Payment Cycle</option>
                            <option @if($getInvoice->payment_cycle == "MONTHLY") selected @endif value="MONTHLY">Monthly</option>
                            <option @if($getInvoice->payment_cycle == "QUARTERLY") selected @endif value="QUARTERLY">Quarterly</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Payment Method<span class="mandatory">*</span></label>
                        <select data-placeholder="Select Batches" name="payment_method" data-search="true" id="invoice_payment_method" class="form-control menu-list w-full" requried>
                            <option value="">Select Payment Method</option>
                            <option @if($getInvoice->payment_method == "1") selected @endif value="1">Cash</option>
                            <option @if($getInvoice->payment_method == "2") selected @endif value="2">Online/UPI</option>
                            <option @if($getInvoice->payment_method == "3") selected @endif value="3">Cheque</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label>Payment Remarks</label>
                        <textarea class="w-full form-control mt-2" name="payment_remarks" placeholder="Enter Txn reference no, cheque no etc.">{{ $getInvoice->payment_remarks }}</textarea>
                    </div>

                    <div class="monthly @if($getInvoice->payment_cycle == 'QUARTERLY') hide @endif">
                        <div class="mt-3">
                            <label>Month<span class="mandatory">*</span></label><br/>
                            <select data-placeholder="Select Month" name="month" data-search="true" class="form-control col-span-3">
                                <option value="">Select Month</option>
                                <option value="1" @if($getInvoice->month == 1) selected="selected" @endif>January</option>
                                <option value="2" @if($getInvoice->month == 2) selected="selected" @endif>February</option>
                                <option value="3" @if($getInvoice->month == 3) selected="selected" @endif>March</option>
                                <option value="4" @if($getInvoice->month == 4) selected="selected" @endif>April</option>
                                <option value="5" @if($getInvoice->month == 5) selected="selected" @endif>May</option>
                                <option value="6" @if($getInvoice->month == 6) selected="selected" @endif>June</option>
                                <option value="7" @if($getInvoice->month == 7) selected="selected" @endif>July</option>
                                <option value="8" @if($getInvoice->month == 8) selected="selected" @endif>August</option>
                                <option value="9" @if($getInvoice->month == 9) selected="selected" @endif>September</option>
                                <option value="10" @if($getInvoice->month == 10) selected="selected" @endif>October</option>
                                <option value="11" @if($getInvoice->month == 11) selected="selected" @endif>November</option>
                                <option value="12" @if($getInvoice->month == 12) selected="selected" @endif>December</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label>Year<span class="mandatory">*</span></label><br/>
                            <select data-placeholder="Select Batches" name="year" data-search="true" class="form-control col-span-3">
                                <option value="">Select Payment Cycle</option>
                                @if(!is_null($year))
                                    @foreach($year as $yk => $yv)
                                        <option value="{{ $yv }}" @if($getInvoice->year == $yv) selected="selected" @endif>{{ $yv }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="quartely @if($getInvoice->payment_cycle == 'MONTHLY') hide @endif">
                        <div class="mt-3">
                            <label>Quater<span class="mandatory">*</span></label><br/>
                            <select data-placeholder="Select Quater" name="quater" data-search="true" class="form-control col-span-3">
                                <option value="">Select Quater</option>
                                <option value="4" @if($getInvoice->month == 4) selected="selected" @endif>April to June</option>
                                <option value="7" @if($getInvoice->month == 7) selected="selected" @endif>July to September</option>
                                <option value="10" @if($getInvoice->month == 10) selected="selected" @endif>October to December</option>
                                <option value="1" @if($getInvoice->month == 1) selected="selected" @endif>January to March</option>
                            </select>
                        </div>            

                        <div class="mt-3">
                            <label>Year<span class="mandatory">*</span></label><br/>
                            <select data-placeholder="Select Year" name="qyear" data-search="true" class="form-control col-span-3">
                                <option value="">Select Year</option>
                                @if(!is_null($year))
                                    @foreach($year as $yk => $yv)
                                        <option value="{{ $yv }}" @if($getInvoice->year == $yv) selected="selected" @endif>{{ $yv }}</option>
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
                            <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                        </tr>
                    </thead>
                    <tbody class="invoice_row">
                    @php $ik = 0; @endphp
                    @if(!is_null($getInvoice->invoice_details))
                        @foreach($getInvoice->invoice_details as $ik => $iv)
                            <tr>
                                <input type="hidden" name="data[{{$ik}}][invoice_detail_id]" id="invoice_detail_id{{$ik}}" value="{{ $iv->id }}">
                                <!-- <td class="border">1</td> -->
                                <td class="border">
                                    <input type="text" name="data[{{$ik}}][title]" class="form-control inTitle widthFifty" value="{{ $iv->perticulars }}" required>
                                </td>
                                <td class="border">
                                    <input type="number" name="data[{{ $ik }}][qty]" class="form-control widthFifty inqty qty numeric qty{{ $ik }}" data-id="{{ $ik }}" value="{{ $iv->qty }}" required>
                                </td>
                                <td class="border">
                                    <input type="text" name="data[{{ $ik }}][fees]" class="form-control widthFifty fees numeric fees{{ $ik }}"  data-id="{{ $ik }}" value="{{ $iv->fees }}" required>
                                </td>
                                <td class="border">
                                    <input type="text" name="data[{{ $ik }}][hsn]" class="form-control widthFifty numeric" value="{{ $iv->hsn }}">
                                </td>
                                <td class="border">
                                    <input type="text" name="data[{{ $ik }}][total]" class="form-control widthFifty total numeric total{{ $ik }}"  data-id="{{ $ik }}" value="{{ $iv->total }}" required>
                                </td>
                                @if($ik == 0)
                                    <td class="border">
                                        Default
                                    </td>
                                @else
                                    <td class="border"> 
                                        <span class="removeDiv btn btn-danger" style="cursor:pointer;" data-id="{{ $ik }}">X</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <!-- <td class="border">1</td> -->
                            <td class="border">
                                <input type="text" name="data[0][title]" class="form-control inTitle widthFifty" required data-msg="Enter particulars">
                            </td>
                            <td class="border">
                                <input type="number" name="data[0][qty]" class="form-control widthFifty inqty qty numeric qty0" data-id="0" required data-msg="Enter QTY">
                            </td>
                            <td class="border">
                                <input type="text" name="data[0][fees]" class="form-control widthFifty fees numeric fees0"  data-id="0" required data-msg="Enter fees">
                            </td>
                            <td class="border">
                                <input type="text" name="data[0][hsn]" class="form-control widthFifty numeric">
                            </td>
                            <td class="border">
                                <input type="text" name="data[0][total]" class="form-control widthFifty total numeric total0"  data-id="0">
                            </td>
                            <td class="border">
                                Default
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    <a href="javascript:void(0);" id="addVideo" class="btn btn-primary w-30 mr-1 mb-2 mt-4 addNewRow" data-id="{{ $ik + 1 }}">Add New </a>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-6 xxl:col-span-6">
            <!-- BEGIN: Change Password -->
            <div class="intro-y box lg:mt-5">
                <div class="p-5">

                    <div class="mt-3">
                        <label>Discount (Rs.)</label>
                        <input type="text" name="discount" class="input w-full border form-control mt-2 discount" placeholder="Discount (Rs.)"  value="0" value="{{ $getInvoice->discount }}" />
                    </div>

                    <div class="mt-3">
                        <label>Total Amount</label>
                        <input type="text" name="total_amount" class="input w-full border form-control mt-2 grandTotal" placeholder="Total Amount" value="{{ $getInvoice->amount }}" />
                    </div>

                    <div class="mt-3">
                        <label>Roundoff</label>
                        <input type="text" name="round_off" id="round_off" class="input w-full border form-control mt-2" placeholder="Roundoff" value="{{ $getInvoice->round_off }}" />
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
                        <input type="text" name="total_in_words" class="input w-full border form-control mt-2 numeric" id="totalInWords" placeholder="Total in Words" value="{{ $getInvoice->amount_words }}" />
                    </div>

                    <div class="mt-3">
                        <label>T&C</label>
                        <textarea class="w-full form-control mt-2" name="terms_and_conditions" placeholder="Terms and conditions">{{ $getInvoice->terms_and_conditions }}</textarea>
                    </div>
                </div>
            </div>
            <!-- END: Change Password -->
        </div>
        <div class="col-span-12 lg:col-span-6 xxl:col-span-6">
            <button type="submit" class="btn btn-primary w-24 mr-1 mb-2 mt-4" name="btn_submit" value="list">Update</button>

            <a href="{{ route('admin.invoiceList') }}" class="btn btn-danger w-24 mr-1 mb-2 mt-4">Cancel</a>
        </div>
    </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    $(document).on('click','.addNewRow',function(){
        
        var i = $(this).data('id');

        var html = '<tr class="removeDiv'+i+'"><td class="border"> <input type="text" name="data['+i+'][title]" class="form-control widthFifty" required data-msg="Enter particulars"></td><td class="border"> <input type="number" name="data['+i+'][qty]" class="form-control widthFifty numeric qty qty'+i+'" data-id="'+i+'" required data-msg="Enter QTY"></td><td class="border"> <input type="text" name="data['+i+'][fees]" class="form-control widthFifty fees numeric fees'+i+'" data-id="'+i+'" required data-msg="Enter fees"></td><td class="border"> <input type="text" name="data['+i+'][hsn]" class="form-control widthFifty numeric"></td><td class="border"> <input type="text" name="data['+i+'][total]" class="form-control widthFifty numeric total total'+i+'" data-id="'+i+'"></td><td class="border"> <span class="removeDiv btn btn-danger" style="cursor:pointer;" data-id="'+i+'">X</span></td></tr>';
        i++;
        $('.invoice_row').append(html);
        $(this).data('id',i)
    }); 

    $(document).on('click','.removeDiv',function(){
        $('.removeDiv'+$(this).data('id')).remove();
    });

    function calculate(index){
        var qty = $('.qty'+index).val();
        var fees = $('.fees'+index).val();

        if(qty != '' && fees != ''){
            var total = qty * fees;
            $('.total'+index).val(total);
        }
        calculateTotal();
    }

    $(document).on('focusout','.qty',function(){
        calculate($(this).data('id'));
    });
    $(document).on('focusout','.fees',function(){
        calculate($(this).data('id'));
    });
    $(document).on('focusout','.discount',function(){
        calculateTotal()
    });

    function calculateTotal(){
        var sum = 0;

        $(".total").each(function(){
            if($(this).val() != ''){
                sum += parseFloat($(this).val());
            }
        });

        var discount = $('.discount').val();
        var total = sum - discount;
        
        var roundOff = Math.round(sum);
        var totalValue = sum - roundOff;

        $('.grandTotal').val(roundOff)
        $('#totalInWords').val(inWords(roundOff))
        $('#round_off').val(totalValue)
    }

    var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
    var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

    function inWords (num) {
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        return str;
    }
</script>
@endsection